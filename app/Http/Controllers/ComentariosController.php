<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Http\Requests\ComentarioGeneralRequest;
use App\Http\Requests\ComentarioProductoRequest;
use App\ProductComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ComentariosController extends Controller
{
    /*
        Descripción: función que muestra la pantalla de comentarios.
        Page: resources/views/shop/comentarios
        Route name: comentario_general.index
        Route URL: /comentarios
        Paramétros:
        Modelos: Comment
        Retorna: $comentarios
    */
    public function comentario_general_index()
    {
        $comentarios = Comment::orderBy('id', 'DESC')->paginate(20);
        return view('shop.comentarios', compact('comentarios'));
    }

    /*
        Descripción: función para crear un nuevo comentario.
        Page: resources/views/shop/comentarios
        Route name: comentario_general.nuevo
        Route URL: /comentario/general/nuevo
        Paramétros: $request
        Modelos: Comment
        Retorna: $notificacion
    */
    public function comentario_general_nuevo(ComentarioGeneralRequest $request)
    {
        $comentario = new Comment();
        $comentario->comment = $request->comment;
        $comentario->user_id = Auth::user()->id;
        $comentario->save();

        $notificacion = array(
            'message' => 'Comentario creado.',
            'alert-type' => 'success'
        );

        return redirect()->route('comentario_general.index')->with($notificacion);
    }

    /*
        Descripción: función para eliminar un comentario.
        Page: resources/views/shop/comentarios
        Route name: comentario_general.eliminar
        Route URL: /comentario/general/eliminar/{id}
        Paramétros: $id
        Modelos: Comment
        Retorna: $notificacion
    */
    public function comentario_general_eliminar(Comment $id)
    {
        $id->delete();

        $notificacion = array(
            'message' => 'Comentario eliminado.',
            'alert-type' => 'success'
        );

        return redirect()->route('comentario_general.index')->with($notificacion);
    }

    /*
        Descripción: función para crear un nuevo comentario en el producto.
        Page: resources/views/shop/detalle
        Route name: comentario_producto.nuevo
        Route URL: /comentario/producto/nuevo
        Paramétros: $request
        Modelos: ProductComment
        Retorna: $notificacion
    */
    public function comentario_producto_nuevo(ComentarioProductoRequest $request)
    {
        $comentario = new ProductComment();
        $comentario->comment = $request->comment;
        $comentario->product_id = $request->product_id;
        $comentario->user_id = Auth::user()->id;
        $comentario->save();

        $notificacion = array(
            'message' => 'Comentario creado.',
            'alert-type' => 'success'
        );

        return redirect()->route('consulta.detalle',['producto' => $comentario->product_id])->with($notificacion);
    }

    /*
        Descripción: función para eliminar un comentario del producto.
        Page: resources/views/shop/detalle
        Route name: comentario_producto.eliminar
        Route URL: /comentario/producto/eliminar/{id}
        Paramétros: $id
        Modelos: ProductComment
        Retorna: $notificacion
    */
    public function comentario_producto_eliminar(ProductComment $id)
    {
        $id->delete();

        $notificacion = array(
            'message' => 'Comentario eliminado.',
            'alert-type' => 'success'
        );

        return redirect()->route('consulta.detalle',['producto' => $id->product_id])->with($notificacion);
    }
}
