<?php

use App\User;
use App\Brand;
use App\Image;
use App\Order;
use App\Credit;
use App\Detail;
use App\Comment;
use App\Company;
use App\Product;
use App\Category;
use App\SubCategory;
use App\CompanyPhone;
use App\DiscountRate;
use App\CompanyAddress;
use App\ProductComment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        factory(DiscountRate::class, 10)->create();
        echo "Tipos de creditos.".PHP_EOL;
        factory(Company::class, 1)->create();
        echo "Nombre de la empresa ingresado.".PHP_EOL;
        factory(CompanyPhone::class, 3)->create();
        echo "Teléfonos de la empresa ingresado.".PHP_EOL;
        factory(CompanyAddress::class, 4)->create();
        echo "Direcciones de la empresa agregados.".PHP_EOL;
        factory(User::class, 25)->create();
        echo "Usuario ingresados".PHP_EOL;
        factory(Credit::class, 20)->create();
        echo "Creditos a usuarios.".PHP_EOL;
        factory(Comment::class, 100)->create();
        echo "Comentarios ingresados".PHP_EOL;
        factory(Brand::class, 25)->create();
        echo "Marcas de productos ingresados".PHP_EOL;
        factory(Category::class, 10)->create();
        echo "Categorias para productos ingresados".PHP_EOL;
        factory(SubCategory::class, 20)->create();
        echo "Sub categorias para productos ingresados".PHP_EOL;
        factory(Product::class, 75)->create();
        echo "Productos ingresados".PHP_EOL;
        //factory(Order::class, 25)->create();
        echo "Pedidos ingresados".PHP_EOL;
        //factory(Detail::class, 100)->create();
        echo "Detalle de pedidos ingresados".PHP_EOL;
        factory(Image::class, 300)->create();
        echo "Imagenes para productos ingresados".PHP_EOL;
        factory(ProductComment::class, 50)->create();
        echo "Comentarios para los productos ingresados".PHP_EOL;

        Artisan::call('storage:link');
    }
}
