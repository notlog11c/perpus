<?php

namespace App;

use Session;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    protected $fillable = ['name'];

    public function books()
    {
        return $this->hasMany(Book::class);
    }

    public static function boot()
    {
        parent::boot();
        
        self::deleting(function ($author){

        
            if ($author->books->count() > 0) {
                
                $messageHtml = 'penulis tidak bisa dihapus karena masih memiliki buku!';
                $messageHtml .= '<ul>';
                foreach ($author->books as $book) {
                    $messageHtml .= "<li>$book->title</li>";
                }

                $messageHtml .= '<ul>';

                Session::flash('flash_notification', [
                    'level' => 'danger',
                    'message' => $messageHtml,
                ]);

                return false;
            }
        });
    }
}
