<?php

namespace App\Traits;

use Dimsav\Translatable\Translatable as DTranslatable;
use App\Language;

trait Translatable {
    use DTranslatable {
        DTranslatable::translate as parentTranslate;
        DTranslatable::getTranslation as parentGetTranslation;
    }

    /**
     * Since we are storing the list of locales in a database table, we are going to
     * pass a Language model to our translate function instead of a code
     *
     * @param bool        $withFallback
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function translate($language, $withFallback = null) {
        if($language instanceof Language) {
            $language = $language->code;
        }
        return $this->parentTranslate($language, $withFallback);   
    }

    public function getTranslation($language, $withFallback = null) {
        if($language instanceof Language) {
            $language = $language->code;
        }
        return $this->parentGetTranslation($language, $withFallback);
    }
}