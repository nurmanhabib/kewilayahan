<?php

namespace Nurmanhabib\Kewilayahan;

trait KewilayahanFormTrait
{
    public function formSelect($tableAndWhereId = 'provinsi', $selected = null, $attributes = [])
    {
        $this->setOutput('arraypluck');

        $options    = $this->load($tableAndWhereId);
        $fieldName  = $this->getTableName() . '_id';

        return $this->getFormBuilder($fieldName, $options, $selected, array_merge(['class' => 'form-control'], $attributes));
    }

    private function getFormBuilder($fieldName, $options, $selected, $extras)
    {
        $attributes = '';

        foreach ($extras as $prop => $value) {
            $attributes .= ' ' . $prop . '="'.$value.'"';
        }

        $html = '<select name="'.$fieldName.'"'.$attributes.'>';

        foreach ($options as $value => $text) {
            if ($value == $selected)
                $html .= '<option value="'.$value.'" selected>'.$text.'</option>';
            else
                $html .= '<option value="'.$value.'">'.$text.'</option>';
        }

        $html .= '</select>';

        return $html;
    }
}