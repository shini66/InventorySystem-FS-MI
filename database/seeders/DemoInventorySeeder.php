<?php

namespace Database\Seeders;

use App\Models\Movement;
use App\Models\Product;
use Illuminate\Database\Seeder;

class DemoInventorySeeder extends Seeder
{
    /**
     * Seed a larger set of demo inventory data so pagination is visible.
     */
    public function run(): void
    {
        $categories = ['Electrónica', 'Oficina', 'Papelería', 'Hardware', 'Mobiliario'];
        $names = [
            'Impresora EPSON', 'Monitor 24"', 'Mouse Logitech', 'Notebook HP', 'Resma A4',
            'Teclado Mecánico', 'Auriculares Sony', 'Webcam Full HD', 'Pendrive 32GB', 'Router Wi-Fi 6',
            'Proyector', 'Micrófono USB', 'Disco SSD 512GB', 'Cable HDMI 2m', 'Multifunción Brother',
            'Silla ergonómica', 'Escritorio 120cm', 'Lámpara de escritorio', 'Pizarra blanca', 'Carpeta A4',
            'Marcadores', 'Abrochadora', 'Perforadora', 'Archivador', 'Tóner HP',
        ];

        foreach ($names as $i => $name) {
            Product::updateOrCreate(
                ['sku' => 'DEMO-'.str_pad((string) $i, 3, '0', STR_PAD_LEFT)],
                [
                    'name' => $name,
                    'description' => 'Producto de demostración.',
                    'category' => $categories[$i % count($categories)],
                    'stock' => rand(2, 80),
                ]
            );
        }

        foreach (Product::all() as $product) {
            $count = rand(1, 3);

            Movement::factory()->count($count)->create(['product_id' => $product->id]);
        }
    }
}
