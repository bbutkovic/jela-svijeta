<?php

namespace App\Traits;

use Dimsav\Translatable\Translatable as DTranslatable;
use App\Language;

trait Translatable {
    use DTranslatable {
        DTranslatable::translate as parentTranslate;
    }

    /**
     * Since we are storing the list of locales in a database table, we are going to
     * pass a Language model to our translate function instead of a code
     *
     * @param Language $language
     * @param bool        $withFallback
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function translate(Language $language, $withFallback = false) {
        $locale = $language->id;
        return $this->parentTranslate($locale, $withFallback);   
    }
}