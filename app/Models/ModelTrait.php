<?php

namespace App\Models;


trait ModelTrait
{


    public function getTranslateInputsOnly($array = [])
    {
        $array = [];
        foreach (config('laravellocalization.supportedLocales') as $key => $value) {
            foreach ($this->translateable as $col) {
                $array[] = $col . '_' . $key;
            }
        }
        return $array;
    }

    public function getTransFromarray($cols = [])
    {
        $array = [];
        foreach (config('laravellocalization.supportedLocales') as $key => $value) {
            foreach ($this->translateable as $col) {
                if (in_array($col, $cols)) {
                    $array[] = $col . '_' . $key;
                }
            }
        }
        return $array;
    }

    public function getFillable()
    {
        return array_merge($this->fillable, $this->getTranslateInputsOnly());
    }
}
