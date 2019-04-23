<?php

namespace App\Traits;

use App\Language;

trait AcceptsLanguage {
    protected $lang;

    public function setLanguage(Language $lang) {
        $this->lang = $lang;
        return $this;
    }

    protected function passLanguage($collection) {
        return $collection->each->setLanguage($this->lang);
    }
}