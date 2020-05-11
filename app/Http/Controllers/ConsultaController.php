<?php

namespace App\Http\Controllers;

use App\Company;
use App\Product;
use App\Category;
use App\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class ConsultaController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /*
        Descripción: función que muestra información de ofertas, productos y categorías en la vista index.
        Page: resources/views/shop/index
        Route name: consulta.index
        Route URL: /
        Paramétros:
        Modelos: Product, Category
        Retorna: $ofertas, $productos, $categorias
    */
    public function index()
    {
        $ofertas = Product::where('offer',true)->get();
        $productos = Product::with(['images:id,photo,product_id'])->where('current',true)->orderBy('id', 'DESC')->take(6)->get();
        $categorias = Category::with(['sub_categories:id,name,category_id'])->get();

        return view('shop.index', compact('ofertas','productos','categorias'));
    }

    /*
        Descripción: función que muestra información de productos y categorías en la vista productos.
        Page: resources/views/shop/productos
        Route name: consulta.productos
        Route URL: /productos
        Paramétros:
        Modelos: Product, Category
        Retorna: $productos, $categorias
    */
    public function productos()
    {
        $productos = Product::where('current',true)->orderBy('id','DESC')->paginate(12);
        $categorias = Category::with(['sub_categories:id,name,category_id'])->get();

        return view('shop.productos', compact('productos','categorias'));
    }

    /*
        Descripción: función que muestra información del producto seleccionado y las categorías en la vista detalle.
        Page: resources/views/shop/detalle
        Route name: consulta.detalle
        Route URL: /producto/{producto}/detalle
        Paramétros: $product->id
        Modelos: Product, Category
        Retorna: $producto, $categorias
    */
    public function detalle(Product $producto)
    {
        $categorias = Category::with(['sub_categories:id,name,category_id'])->get();

        return view('shop.detalle', compact('producto','categorias'));
    }

    /*
        Descripción: función que muestra información de los productos que pertenecen a la sub categoría seleccionada en la vista sub_categoria.
        Page: resources/views/shop/sub_categoria
        Route name: consulta.sub_categoria
        Route URL: /sub_categoria/{sub_categoria}/productos
        Paramétros: $sub_categoria->id
        Modelos: SubCategory, Category
        Retorna: $categorias, $nombre_sub_categoria, $productos
    */
    public function sub_categoria(SubCategory $sub_categoria)
    {
        $categorias = Category::with(['sub_categories:id,name,category_id'])->get();
        $nombre_sub_categoria = $sub_categoria->getCategoryAttribute();
        $productos = Product::where('sub_category_id',$sub_categoria->id)->where('current',true)->orderBy('id','DESC')->paginate(12);

        return view('shop.sub_categoria', compact('categorias','nombre_sub_categoria','productos'));
    }

    /*
        Descripción: función para buscar productos.
        Page: resources/views/shop/buscar
        Route name: consulta.buscar
        Route URL: /buscar/producto
        Paramétros: $request
        Modelos: Product
        Retorna: $productos
    */
    public function buscar(Request $request)
    {
        $productos = Product::search($request->search)->where('current',true)->paginate(10);

        return view('shop.buscar', compact('productos'));
    }

    /*
        Descripción: función que muestra la pantalla de empresa.
        Page: resources/views/shop/empresa
        Route name: consulta.empresa
        Route URL: /empresa
        Paramétros:
        Modelos: Company
        Retorna: $empresa
    */
    public function empresa()
    {
        $empresa = Company::where('current', true)->first();

        if(is_null($empresa))
        {
            $notificacion = array(
                'message' => 'No hay información de la empresa.',
                'alert-type' => 'info'
            );

            return Redirect::route('consulta.index')
                            ->with($notificacion);
        }

        return view('shop.empresa', compact('empresa'));
    }

    /*
        Descripción: función que muestra la pantalla de contacto.
        Page: resources/views/shop/contacto
        Route name: consulta.contacto
        Route URL: /contacto
        Paramétros:
        Modelos: Company
        Retorna: $contacto
    */
    public function contacto()
    {
        $contacto = Company::where('current', true)->first();
        return view('shop.contacto', compact('contacto'));
    }
}
