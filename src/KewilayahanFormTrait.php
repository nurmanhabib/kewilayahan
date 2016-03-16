<?php

namespace Nurmanhabib\Kewilayahan;

trait KewilayahanFormTrait
{
    public function formSelect($fieldName, $tableAndWhereId = 'provinsi', $selected = null, $attributes = [])
    {
        $this->setOutput('arraypluck');

        $options    = $this->load($tableAndWhereId, null, false);

        if (is_array($tableAndWhereId)) {
            $tableName = $tableAndWhereId[0];
        } else {
            $tableName = $tableAndWhereId;
        }

        $fieldId    = $this->getFieldId($tableName);
        $attributes = array_merge(
            ['class' => 'form-control', 'id' => $fieldId],
            $attributes
        );

        return $this->getFormBuilder($fieldName, $options, $selected, $attributes);
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

    private function getFieldId($table)
    {
        $fields = [
            'provinsi'  => 'provinsi_id',
            'kabkota'   => 'kabkota_id',
            'kecamatan' => 'kecamatan_id',
            'desa'      => 'desa_id',
        ];

        return $fields[$table];
    }

    public function script()
    {
        $loading    = 'Loading...';
        $url        = url($this->config['api']['path']);

        $script  = "<script>var url = '$url';";
        $script .= "var loading = '$loading';" . PHP_EOL;
        $script .= file_get_contents(__DIR__ . '/../assets/kewilayahan.chained.js');
        $script .= "</script>";
        
        return $script;
    }
}