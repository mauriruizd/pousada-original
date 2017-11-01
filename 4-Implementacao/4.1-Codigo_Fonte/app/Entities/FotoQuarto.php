<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;

class FotoQuarto extends Model
{
    protected $table = 'fotos_quartos';

    protected $fillable = [
        'id',
        'id_quarto',
        'url'
    ];

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getIdQuarto()
    {
        return $this->idQuarto;
    }

    /**
     * @param mixed $idQuarto
     */
    public function setIdQuarto($idQuarto)
    {
        $this->idQuarto = $idQuarto;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return url($this->url);
    }

    /**
     * @param mixed $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    public function quarto()
    {
        return $this->belongsTo(Quarto::class, 'id_quarto', 'id');
    }

    public function setUrlAttribute(UploadedFile $file)
    {
        $fileName = $file->getClientOriginalName();
        $file->move(
            public_path('/img/fotos-quartos'),
            $fileName
        );
        $this->attributes['url'] = 'img/fotos-quartos/' . $fileName;
    }

}
