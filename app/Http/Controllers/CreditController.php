<?php

namespace App\Http\Controllers;

use App\Credit;
use App\DiscountRate;
use App\RequestCredit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\CreditRequest;
use App\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CreditController extends Controller
{
    public function index()
    {
        $creditos_realizados = RequestCredit::with('credit')->where('user_id',Auth::user()->id)->where('current',true)->orderBy('id','DESC')->paginate(10);
        return view('credits.index', compact('creditos_realizados'));
    }

    public function create()
    {
        $creditos = Credit::where('user_id',Auth::user()->id)->orderBy('id','DESC')->paginate(10);
        $descuentos = DiscountRate::all();

        return view('credits.create', compact('descuentos','creditos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreditRequest $request)
    {
        $credito = new Credit();
        $credito->approved = Credit::EN_ESPERA;
        $credito->current = false;
        $credito->discount_rate_id = $request->discount_rate_id;
        $credito->user_id = Auth::user()->id;
        $credito->employee_id = 0;
        $credito->save();

        $notificacion = array(
            'message' => 'Crédito ingresado.',
            'alert-type' => 'success'
        );

        return redirect()->route('credito.create')->with($notificacion);
    }

    public function pagar(RequestCredit $credito)
    {
        try
        {
            DB::beginTransaction();

                $pedido = Order::find($credito->order_id);
                $pedido->sold = true;
                $pedido->save();

                $credito->payment = true;
                $credito->save();

            DB::commit();

            Session::forget('cart');
            $notificacion = array(
                'message' => 'El pago fue acreditado al pedido #' . $pedido->id,
                'alert-type' => 'success'
            );

            return redirect()->route('credito.index')->with($notificacion);
        }
        catch(\Exception $e)
        {
            DB::rollback();
            return redirect()->route('credito.index')->with('error', $e->getMessage());
        }
    }
}
