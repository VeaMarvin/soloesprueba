<div class="col-sm-3">{{--Panel izquierdo--}}
    <div class="left-sidebar">
        <h2>Categorías</h2>
        <div class="panel-group category-products" id="accordian" style="background: #f0f0e9;">{{--Categorias--}}
            @forelse ($categorias as $categoria)
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordian" href="#{{str_replace(' ','',$categoria->name)}}">
                                <span class="badge pull-right">{{ $categoria->sub_categories->count() }}</span>
                                {{$categoria->name}}
                            </a>
                        </h4>
                    </div>
                    <div id="{{str_replace(' ','',$categoria->name)}}" class="panel-collapse collapse">
                        <div class="panel-body">
                            <ul>
                                @forelse($categoria->sub_categories as $sub_categoria)
                                    <li>
                                        <i class="fa fa-angle-right"></i>
                                        <a href="{{route('consulta.sub_categoria',['sub_categoria' => $sub_categoria->id])}}">{{$sub_categoria->name}}</a>
                                        <span class="label label-primary pull-right">{{ $sub_categoria->products->count() }}</span>
                                    </li>
                                @empty
                                    No hay sub categorías
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </div>
            @empty
                No existen categorías
            @endforelse
        </div>{{--./Categorias--}}
    </div>
</div>{{--./Panel izquierdo--}}
