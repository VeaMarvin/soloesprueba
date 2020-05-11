<?php

use App\Brand;
use App\Category;
use App\Comment;
use App\Company;
use App\CompanyAddress;
use App\CompanyPhone;
use App\Detail;
use App\Image;
use App\Order;
use App\Product;
use App\ProductComment;
use App\SubCategory;
use App\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        factory(Company::class, 1)->create();
        echo "Nombre de la empresa ingresado.".PHP_EOL;
        factory(CompanyPhone::class, 3)->create();
        echo "Teléfonos de la empresa ingresado.".PHP_EOL;
        factory(CompanyAddress::class, 4)->create();
        echo "Direcciones de la empresa agregados.".PHP_EOL;
        factory(User::class, 25)->create();
        echo "Usuario ingresados".PHP_EOL;
        factory(Comment::class, 500)->create();
        echo "Comentarios ingresados".PHP_EOL;
        factory(Brand::class, 50)->create();
        echo "Marcas de productos ingresados".PHP_EOL;
        factory(Category::class, 10)->create();
        echo "Categorias para productos ingresados".PHP_EOL;
        factory(SubCategory::class, 50)->create();
        echo "Sub categorias para productos ingresados".PHP_EOL;
        factory(Product::class, 500)->create();
        echo "Productos ingresados".PHP_EOL;
        factory(Order::class, 100)->create();
        echo "Pedidos ingresados".PHP_EOL;
        factory(Detail::class, 500)->create();
        echo "Detalle de pedidos ingresados".PHP_EOL;
        factory(Image::class, 1000)->create();
        echo "Imagenes para productos ingresados".PHP_EOL;
        factory(ProductComment::class, 500)->create();
        echo "Comentarios para los productos ingresados".PHP_EOL;
    }
}
