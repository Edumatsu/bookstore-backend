<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('
            CREATE VIEW view_books_by_author AS
                SELECT 
                a.CodAu,
                a.Nome as "Autor",
                c.Titulo as "Livro",
                c.Editora,
                c.Edicao,
                c.AnoPublicacao,
                c.Valor,
                (SELECT group_concat(Assunto.Descricao)
                    FROM Livro_Assunto 
                    JOIN Assunto ON Assunto.codAs = Livro_Assunto.Assunto_codAs
                    where Livro_Assunto.Livro_Codl = c.Codl) as "Assuntos"
            FROM Autor a
            JOIN Livro_Autor b ON a.CodAu = b.Autor_CodAu
            JOIN Livro c ON b.Livro_Codl = c.Codl
            ORDER BY a.Nome ASC;
        ');
    }
   
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('
            DROP VIEW IF EXISTS `view_books_by_author`;
        ');
    }
};
