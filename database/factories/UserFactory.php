<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Brand;
use App\Category;
use App\Comment;
use App\Company;
use App\CompanyAddress;
use App\CompanyPhone;
use App\Credit;
use App\Detail;
use App\DiscountRate;
use App\Image;
use App\Order;
use App\Product;
use App\ProductComment;
use App\RequestCredit;
use App\SubCategory;
use App\Traicing;
use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(DiscountRate::class, function (Faker $faker) {
    return [
        'quantity' => $quantity = $faker->numberBetween(1, 31),
        'day_month' => $quantity < 13 ? DiscountRate::MES : DiscountRate::DIA
    ];
});

$factory->define(User::class, function (Faker $faker) {
    $foto_uno = 'iVBORw0KGgoAAAANSUhEUgAAAFgAAABYBAMAAACDuy0HAAAAG1BMVEXMzMyWlpbFxcWjo6OxsbG+vr6qqqq3t7ecnJwRtUHbAAAACXBIWXMAAA7EAAAOxAGVKw4bAAAAdklEQVRIiWNgGAWjYBSMglEwCkYBGUBZWMnQCMZUACJ8ik1UjJ2cYUwDIMKnWIhJUEGRgcGN3QDIFAAiIkzW0FAgwuRAwVBBUQYGljYQMwCIiDCZSZQEN7MZM5Di5gAiTIaGcwowNAiH8ygYBaNgFIyCUTAYAQBzNRHuWxEUOAAAAABJRU5ErkJggg==';
    return [
        'name' => $faker->randomElement([$faker->name('male'), $faker->name('female')]),
        'email' => $faker->unique()->freeEmail,
        'password' => 'admin',
        'nickname' => $faker->randomElement([$faker->unique()->userName, null]),
        'avatar' => $foto_uno,
        'admin' => $admin = $faker->randomElement([false, true]),
        'system' => $admin == true ? true : $faker->randomElement([false, true]),
        'remember_token' => Str::random(10)
    ];
});

$factory->define(Credit::class, function (Faker $faker) {
    $user = User::all()->random()->id;
    $credit = Credit::where('user_id', $user)->update(['current' => 0]);
    $employee = User::where('system',true)->take(1)->first()->id;

    if(is_null($employee))
        $employee = 0;

    return [
        'approved' => $approved = $employee > 0 ? $faker->randomElement([Credit::EN_ESPERA, Credit::APROVADO_NO, Credit::APROVADO_SI]) : null,
        'current' => $approved == Credit::APROVADO_SI ? true : false,
        'discount_rate_id' => DiscountRate::all()->random()->id,
        'user_id' => $user,
        'employee_id' => $employee
    ];
});

$factory->define(Comment::class, function (Faker $faker) {
    return [
        'comment' => $faker->unique()->randomElement([$faker->text('50'), $faker->text('75'), $faker->text('100'), $faker->text('225')]),
        'user_id' => User::all()->random()->id
    ];
});

$factory->define(Brand::class, function (Faker $faker) {
    return [
        'name' => $faker->unique()->jobTitle
    ];
});

$factory->define(Category::class, function (Faker $faker) {
    return [
        'name' => $faker->unique()->state
    ];
});

$factory->define(SubCategory::class, function (Faker $faker) {
    return [
        'name' => $faker->unique()->jobTitle,
        'category_id' => Category::all()->random()->id
    ];
});

$factory->define(Product::class, function (Faker $faker) {
    return [
        'title' => $faker->randomElement([$faker->text(8), $faker->text(10), $faker->text(15)]),
        'description' => $faker->text(150),
        'price' => $faker->randomFloat(2, 1, 15000),
        'offer' => $offer = $faker->randomElement([true, false]),
        'discount' => $offer === true ? $faker->numberBetween(1, 100) : 0,
        'new_product' => $faker->randomElement([true, false]),
        'stock' => $faker->numberBetween(1, 10000),
        'brand_id' => Brand::all()->random()->id,
        'sub_category_id' => SubCategory::all()->random()->id,
        'current' => $faker->randomElement([true, false])
    ];
});

$factory->define(Order::class, function (Faker $faker) {
    $user = User::all()->random()->id;
    $status = $faker->randomElement([Order::PEDIDO, Order::PROCESO, Order::FACTURADO, Order::ENTREGADO, Order::ANULADO]);
    $credit = Credit::where('user_id',$user)->where('current',true)->first();
    $employee = 0;

    if(is_null($credit))
        $type_payment = Order::CONTADO;
    else
        $type_payment = Order::CREDITO;

    if($status == Order::FACTURADO)
    {
        $employee = User::where('system',true)->take(1)->first()->id;

        if(is_null($employee))
            $employee = 1;
    }

    return [
        'nit' => $faker->numerify('######-#'),
        'name_complete' => $faker->randomElement([$faker->name('male'), $faker->name('female')]),
        'email' => $faker->freeEmail,
        'direction' => "{$faker->streetAddress}, {$faker->streetName}, {$faker->city}",
        'phone' => $faker->numerify('#######'),
        'status' => $status,
        'observation' => $faker->randomElement([$faker->text(150), null]),
        'total' => 0,
        'user_id' => $user,
        'type_payment' => $type_payment,
        'sold' => $status == Order::CONTADO ? true : false,
        'employee_id' => $employee
    ];
});

$factory->define(Detail::class, function (Faker $faker) {

    $order = Order::all()->random();

    do{
        $cantidad = $faker->numberBetween(1,10);
        $product = Product::all()->random();
        $resta = $product->stock - $cantidad;
    }while($resta < 0);

    $price = $product->price;
    $discount = $product->discount;

    if($product->offer)
    {
        $multiplicar_dividir_porcentaje = round(($price*$discount)/100,2);
        $restar_descuento = $price - $multiplicar_dividir_porcentaje;
    }
    else
    {
        $restar_descuento = $price;
    }

    $nuevo_precio = round($restar_descuento, 2);
    $subtotal = $cantidad*$nuevo_precio;
    $product->stock -= $resta;
    $product->save();

    $nuevo_precio = number_format($restar_descuento,2);
    $order->total += $subtotal;
    $order->save();

    $pagado = false;
    if($order->type_payment == Order::CREDITO)
    {
        $credit = Credit::where('user_id',$order->user_id)->where('current',true)->first();

        $request_credit = RequestCredit::where('order_id',$order->id)->first();

        if(is_null($request_credit))
        {
            $discount_rate = DiscountRate::find($credit->discount_rate_id);

            switch ($discount_rate->day_month) {
                case DiscountRate::DIA:
                    $sumar = 'days';
                    break;

                case DiscountRate::MES:
                    $sumar = 'month';
                    break;
            }

            $request_credit = new RequestCredit();
            $request_credit->date_start = date('Y-m-d', strtotime($order->created_at));
            $request_credit->date_end = date("Y-m-d",strtotime("{$request_credit->date_start} + {$discount_rate->quantity} {$sumar}"));
            $request_credit->order_id = $order->id;
            $request_credit->credit_id = $credit->id;
            $request_credit->user_id = $order->user_id;
        }

        $request_credit->total = $order->total;
        $request_credit->payment = $pagado = Order::FACTURADO == $order->status ? $faker->randomElement([true, false]) : false;
        $request_credit->current = $pagado;
        $request_credit->save();
    }

    $order->sold = $order->type_payment == Order::CONTADO ? true : $pagado;
    $order->save();

    $employee = User::where('system',true)->take(1)->first()->id;

    if(is_null($employee))
        $employee = 1;

    $search_traicing = Traicing::where('order_id',$order->id)->first();

    if(is_null($search_traicing))
    {
        switch ($order->status) {
            case Order::PROCESO:
                    $new = new Traicing();
                    $new->status = Order::PEDIDO;
                    $new->order_id = $order->id;
                    $new->user_id = $employee;
                    $new->save();

                    $new = new Traicing();
                    $new->status = Order::PROCESO;
                    $new->order_id = $order->id;
                    $new->user_id = $employee;
                    $new->save();
                break;

            case Order::FACTURADO:
                    $new = new Traicing();
                    $new->status = Order::PEDIDO;
                    $new->order_id = $order->id;
                    $new->user_id = $employee;
                    $new->save();

                    $new = new Traicing();
                    $new->status = Order::PROCESO;
                    $new->order_id = $order->id;
                    $new->user_id = $employee;
                    $new->save();

                    $new = new Traicing();
                    $new->status = Order::FACTURADO;
                    $new->order_id = $order->id;
                    $new->user_id = $employee;
                    $new->save();
                break;

            case Order::ENTREGADO:
                    $new = new Traicing();
                    $new->status = Order::PEDIDO;
                    $new->order_id = $order->id;
                    $new->user_id = $employee;
                    $new->save();

                    $new = new Traicing();
                    $new->status = Order::PROCESO;
                    $new->order_id = $order->id;
                    $new->user_id = $employee;
                    $new->save();

                    $new = new Traicing();
                    $new->status = Order::FACTURADO;
                    $new->order_id = $order->id;
                    $new->user_id = $employee;
                    $new->save();

                    $new = new Traicing();
                    $new->status = Order::ENTREGADO;
                    $new->order_id = $order->id;
                    $new->user_id = $employee;
                    $new->save();
                break;

            case Order::ANULADO:
                    $new = new Traicing();
                    $new->status = Order::PEDIDO;
                    $new->order_id = $order->id;
                    $new->user_id = $employee;
                    $new->save();

                    $new = new Traicing();
                    $new->status = Order::ANULADO;
                    $new->order_id = $order->id;
                    $new->user_id = $employee;
                    $new->save();
                break;
        }
    }

    return [
        'quantity' => $cantidad,
        'product' => "{$product->title}, {$product->getBrandAttribute()}, {$product->getCategoryAttribute()}",
        'price' => $product->price,
        'discount' => $product->discount,
        'subtotal' => $subtotal,
        'order_id' => $order->id,
        'product_id' => $product->id
    ];
});

$factory->define(Image::class, function (Faker $faker) {
    $foto_uno = 'iVBORw0KGgoAAAANSUhEUgAAAFgAAABYBAMAAACDuy0HAAAAG1BMVEXMzMyWlpbFxcWjo6OxsbG+vr6qqqq3t7ecnJwRtUHbAAAACXBIWXMAAA7EAAAOxAGVKw4bAAAAdklEQVRIiWNgGAWjYBSMglEwCkYBGUBZWMnQCMZUACJ8ik1UjJ2cYUwDIMKnWIhJUEGRgcGN3QDIFAAiIkzW0FAgwuRAwVBBUQYGljYQMwCIiDCZSZQEN7MZM5Di5gAiTIaGcwowNAiH8ygYBaNgFIyCUTAYAQBzNRHuWxEUOAAAAABJRU5ErkJggg==';
    $foto_dos = '/9j/4AAQSkZJRgABAQAAAQABAAD/2wCEAAkGBw8QEA8NEBINDxAPDxIPDQ8NDQ8PDQ0NFREWFhURFRUYHiggGCYlGxUVIT0hJSkrLi46Fx8zOD8sNyguLisBCgoKDQ0NFQ0PFSsdFSU3NysxKzIrKysrNysrLSsrKysrKystKysrKysrKysrKysrKysrKysrKysrKysrKysrK//AABEIAOEA4QMBIgACEQEDEQH/xAAcAAEAAgMBAQEAAAAAAAAAAAAAAwcCBAYFCAH/xABMEAACAQECBgoNCgMJAAAAAAAAAQIDBBEFBgchMZMSE1FTc5SxstHTFCIjQVJhY2RxcoGR0hckMjM0NXShs8KCo+EVQlRikqKkwcP/xAAWAQEBAQAAAAAAAAAAAAAAAAAAAQL/xAAXEQEBAQEAAAAAAAAAAAAAAAAAEQEh/9oADAMBAAIRAxEAPwC8QAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA/LwP0HO4exyslkbhJ7ZOP0owlFRg9yUm7k/FpPAeVOzeBDXv4ALBBXvyp2fwKfGH1Z+PKpZ97p8ZfVgWGCu3lWs+90+MvqzF5V7PvVPjL6sCxgVw8rNDeocZl1Z+fK1Q3qHGZdWBZAK2+VqhvMOMy6sfK3Q3mHGZdWBZIK1eVyz7zHjMurMXlfs+8x4y+rAswFZPLBZ95jxl9WYvLFQ3hcZfVgWeCrvlls/8Ah/8AkPqzfwTlWsteSi6U43+BUVSV3qtJv2XgWEDXsFupV6ca1GcakJaJRd+fvp7j8RsAAAAAAAAAAAAAAA8PHDDPYllnUTuqSvhS0XqVzbl7Emz22U5lQw1tsrRsX3OhB0ad2iU3mnL35vYBxeAqbwhaJSquTpQ7ZxTd7veaN/5tnbLBFlSuVChm3acZP3tXs5HJpptH8H7jvLgrQ/smzbxZtRT6D8eC7NvFm1FPoN5mEgNCWC7NvFm1FLoMJYLs+82fUUug9BoxkgPNlgqhvVn4vS6DB4Kob1Q1FLoPSkiNoDzXguhvVDUUugwlgqhvdHUUug9GSMJIDzngujvdHU0+gilgyjvdLU0+g9KSIpAebLBlDe6Wqh0EUsGUPApaqB6U0RSQHmzwXR8Cnq4GLwdSSzRUJLPCUVsbpLvNLNn3dJvyIqugI6DJfjM6dp2mpJ7XaHGnK/Rtzv2uftzxv796vLnR8uYLm1KV2Z7G9PvpxaZ9DYl4bVtsdKs7tsj3OutyrHNf7Vc/aB7wAAAAAAAAAAAADx8a8IOz2WrUjfs5La6bWlSlm2XszsojG6+Nmis62dVJ39+5Nsu3Hh/N48KuRlPZRldZ7OvKvmMDUyYr7S/HDkkdzccXkyjmtL8cOSR29wVGflxLcNiBC0YNE+xMJRAhaMJImcTCSA15IjkieSIpICCSIpInkiKYEEkRSRNIikBDJEVXQTSIp6AOdsMrqkfHevemd7kqw1KjbexnftdqTjd4NaKbjJexSXt8RwVh+up8JHnHSYh/eli4b/zkEfQgAAAAAAAAAAAADnsdl3CC8quayoMpsbqFm4WXMLgxz+pp8Kuayo8qiuo2XhJc1BWtkvj2lq9enySO3uONyWq+nan/AJ6fNkduogR3BxJdifjiBDsSOSNhxI5ICCSI2jYlEwkgNeSIJm1JEFVAazRFNGxcQ1EBrTIpInkRMDXkRy6OUlmiP+nKBzlh+up8LHno6LEb70sPD/skc7YPr6XDQ56OixK+9LDw65rA+hQAEAAAAAAAAAAB4GOC7lSXllzWVLlaV1GycJPmotvG36FHhv2yKoywLuVk9epzUFQZKI9xtb8rT5sjudicXklXcLW/LU1/sZ3KRBHsTFxJ9gYyiFQNEckbDiRtAQNEUkbEkRyRUa0kQTRtTRBNAa7iQVEbMkQzQGpURFJGzNEE0BrTRGln9q5SaZHHSvSuUDmMH/X0uGhz0dFifmwlYuHj/wBnO2H7RT4eP6iOgxWzYRsX4mHKQfQ4AKgAAAAAAAAAAPHxkhfGivK/skVNlpV0LF61TkRb+GktjCT0Rnn8V6aRU+XGMXRsU46NsqRf+lMK1skS+bWx+cU/0zulE4jI6r7JbPxVNfyju0iLjC4xlElaMJAQtEckTNGEkBryiRSRsSRFNAa00QyRsTRDJAa8kQTNioQTCNeaNeZszNeoUa8yOmu2XpXKSTPyn9KPpXKBylj+00+Hh+ojoMXM2EbJ+Kp848Cwq+1Ulu2mC/mo6jFexyq4SssYZ2q6qPcUIPZSfuRNMX8ACoAAAAAAAAAACG10FUhKm9Ek091eNFOZVLLLsG5/Ss9qjsvQ4yg+VF0nBZVMEupZK8oK91KdzSWmpDto/lH8gONyNfY7b+Mh+ijvEjgci9WLs1toprbNvhW2P9509rUL0vSuQ768y0/GYtGTMJMDGRE0ZykRSkBjIhkSORDNlEcyCbJZMgmwIqhrzJpyNebCIahBNks2a82BFI/KX0o+suU/JMUZJSTehO9vcS0sDmsGL505eA6s79xxUrn77i2skOBrqdXCM121W+lQv71KMu3kvTJXfwlYYtWGdptE4U07601Si7tG2Tvb9kYyk/EmfR2DrFChRpUKaShShGEUtxK4F5GyACoAAAAAAAAAAAQW2yxqwlTloktK0p6U16GTgCnMLYg2qy2jsuwzdCpe2tgpOk7777mk7vVkriXszGFaXYnut06d7/It4EgqDs7GHzLVw6DB23GDzLVQ6C4gItU47VjB5nqo9Bi7Th/zTVR6C5QIVSsq+HvNdUughqTw7uWfU/0LwAhVESeG9yhqn0EUo4a3KOqfwl+ARHz+6eGfBp6mfwkcqGGPAjqKnwn0IAPnWdDC29x1FT4TCVHCu9ri9T4T6NBR83OhhTRtS1FXoM6OBcJWhqnKnV2Ms0o0rPU7b0tpL3tH0cAOGxAxM7DSr1klUUWqVNS2TpbL6U5vQ5O5LNmWhHcI/QAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAB//9k=';
    return [
        'photo' => $faker->randomElement([$foto_uno, $foto_dos]),
        'product_id' => Product::all()->random()->id
    ];
});

$factory->define(ProductComment::class, function (Faker $faker) {
    return [
        'comment' => $faker->unique()->randomElement([$faker->text('50'), $faker->text('75'), $faker->text('100'), $faker->text('225')]),
        'user_id' => User::all()->random()->id,
        'product_id' => Product::all()->random()->id
    ];
});

$factory->define(Company::class, function (Faker $faker) {
    $logo = "iVBORw0KGgoAAAANSUhEUgAAAIsAAAAnCAYAAAA/x7tqAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAA2tpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuMC1jMDYwIDYxLjEzNDc3NywgMjAxMC8wMi8xMi0xNzozMjowMCAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wTU09Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9tbS8iIHhtbG5zOnN0UmVmPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvc1R5cGUvUmVzb3VyY2VSZWYjIiB4bWxuczp4bXA9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC8iIHhtcE1NOk9yaWdpbmFsRG9jdW1lbnRJRD0ieG1wLmRpZDowMTgwMTE3NDA3MjA2ODExOERCQjhGNzExQzI0RkZBQiIgeG1wTU06RG9jdW1lbnRJRD0ieG1wLmRpZDpGQ0MyOUI5Njg4NjcxMUUzQjU2RTg4OEZEOUEwMjM3QiIgeG1wTU06SW5zdGFuY2VJRD0ieG1wLmlpZDpGQ0MyOUI5NTg4NjcxMUUzQjU2RTg4OEZEOUEwMjM3QiIgeG1wOkNyZWF0b3JUb29sPSJBZG9iZSBQaG90b3Nob3AgQ0MgKE1hY2ludG9zaCkiPiA8eG1wTU06RGVyaXZlZEZyb20gc3RSZWY6aW5zdGFuY2VJRD0ieG1wLmlpZDo5MWYxNTdjZC1hYTRmLTRiNDEtOTE1Ni00NGE3OGQwNjBmNmEiIHN0UmVmOmRvY3VtZW50SUQ9InhtcC5kaWQ6MDE4MDExNzQwNzIwNjgxMThEQkI4RjcxMUMyNEZGQUIiLz4gPC9yZGY6RGVz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";
    return [
        'nit' => $faker->unique()->numerify('######-#'),
        'name' => $faker->company,
        'slogan' => $faker->companySuffix,
        'vision' => $faker->paragraph(3),
        'mision' => $faker->paragraph(3),
        'logotipo' => $logo,
        'ubication_x' => 14.6407204,
        'ubication_y' => -90.5132675,
        'facebook' => $faker->url,
        'twitter' => $faker->url,
        'instagram' => $faker->url,
        'page' => config('app.url')
    ];
});

$factory->define(CompanyPhone::class, function (Faker $faker) {
    return [
        'phone' => $faker->phoneNumber,
        'company_id' => Company::all()->random()->id
    ];
});

$factory->define(CompanyAddress::class, function (Faker $faker) {
    return [
        'direction' => "{$faker->streetAddress}, {$faker->streetName}, {$faker->city}",
        'company_id' => Company::all()->random()->id
    ];
});
