<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $this->call(CategoriesSeeder::class);
         $this->call(ColorsSeeder::class);
         $this->call(TagsSeeder::class);
         $this->call(UsersSeeder::class);
         $this->call(VendorsSeeder::class);
         $this->call(ImagesSeeder::class);
         $this->call(ProductsSeeder::class);
         $this->call(ChatsSeeder::class);
         $this->call(MessagesSeeder::class);
    }
}
