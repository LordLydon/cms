<?php

use App\Page;
use Illuminate\Database\Seeder;

class DashboardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dash = Page::create([
            'name'       => 'Inicio',
            'content'    => '<h1>Bienvenido al CMS!</h1><p>Esta es una p&aacute;gina creada por defecto, para editarla v&eacute; a&nbsp;<a title="Editar P&aacute;gina de Inicio" href="' . url('admin/pages/1/edit') . '">AQU&Iacute;</a>&nbsp;(Pero&nbsp;<a title="Iniciar Sesi&oacute;n" href="' . url('/login') . '">INICIA SESI&Oacute;N</a>&nbsp;primero)</p>',
            'is_private' => false,
            'position'   => 'none',
            'user_id'    => 1,
        ]);
    }
}
