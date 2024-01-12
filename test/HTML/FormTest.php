<?php
declare(strict_types=1);

namespace PChouse\HTML;

use PChouse\Attributes\HTML\Cache\Cache;
use PChouse\Attributes\HTML\CachedForm;
use PChouse\Attributes\HTML\Form;
use PChouse\Resources\MyClass;
use PHPUnit\Framework\TestCase;

class FormTest extends TestCase
{

    /**
     * @test
     * @return array
     * @throws \PChouse\Attributes\HTML\Cache\CacheException
     * @throws \PChouse\Attributes\HTML\HtmlException
     * @throws \PChouse\Attributes\HTML\SerializeException
     */
    public function test(): array
    {
        //<editor-fold desc="Expected array">
        $expect = array (
            'form' =>
                array (
                    'id' => 'MyClass',
                    'accept-charset' => 'utf-8',
                    'action' => '/',
                    'autocomplete' => 'off',
                    'enctype' => 'multipart/form-data',
                    'method' => 'post',
                    'novalidate' => true,
                ),
            'class' =>
                array (
                    'MyClass_hidden1' =>
                        array (
                            'tag' => 'input',
                            'type' => 'hidden',
                            'name' => 'hidden1',
                            'id' => 'MyClass_hidden1',
                            'autocomplete' => 'off',
                            'value' => '',
                        ),
                    'MyClass_hidden2' =>
                        array (
                            'tag' => 'input',
                            'type' => 'hidden',
                            'name' => 'hidden2',
                            'id' => 'MyClass_hidden2',
                            'autocomplete' => 'off',
                            'value' => '',
                        ),
                    'MyClass_select1' =>
                        array (
                            'options' =>
                                array (
                                    0 =>
                                        array (
                                            'value' => '',
                                            'text' => 'Select',
                                        ),
                                    1 =>
                                        array (
                                            'value' => '1',
                                            'text' => 'Option1',
                                            'selected' => true,
                                        ),
                                ),
                            'tag' => 'select',
                            'name' => 'select1',
                            'id' => 'MyClass_select1',
                            'autocomplete' => 'off',
                            'value' => '',
                        ),
                ),
            'properties' =>
                array (
                    'columnStringNull' =>
                        array (
                            'MyClass_columnStringNull' =>
                                array (
                                    'tag' => 'input',
                                    'type' => 'text',
                                    'name' => 'columnStringNull',
                                    'id' => 'MyClass_columnStringNull',
                                    'autocomplete' => 'off',
                                    'value' => '',
                                    'position' => 1,
                                ),
                        ),
                    'columnInt' =>
                        array (
                            'MyClass_columnInt' =>
                                array (
                                    'tag' => 'input',
                                    'type' => 'number',
                                    'name' => 'columnInt',
                                    'id' => 'MyClass_columnInt',
                                    'autocomplete' => 'off',
                                    'value' => '',
                                    'position' => 7,
                                ),
                        ),
                    'columnString' =>
                        array (
                            'MyClass_columnString' =>
                                array (
                                    'tag' => 'input',
                                    'type' => 'text',
                                    'name' => 'columnString',
                                    'id' => 'MyClass_columnString',
                                    'autocomplete' => 'off',
                                    'value' => '',
                                    'position' => 9,
                                ),
                        ),
                    'columnFloat' =>
                        array (
                            'my_class_column_float_1' =>
                                array (
                                    'tag' => 'input',
                                    'type' => 'radio',
                                    'name' => 'columnFloat',
                                    'id' => 'my_class_column_float_1',
                                    'autocomplete' => 'off',
                                    'value' => '',
                                ),
                            'my_class_column_float_2' =>
                                array (
                                    'tag' => 'input',
                                    'type' => 'radio',
                                    'name' => 'columnFloat',
                                    'id' => 'my_class_column_float_2',
                                    'autocomplete' => 'off',
                                    'value' => '',
                                ),
                            'my_class_column_float_3' =>
                                array (
                                    'tag' => 'input',
                                    'type' => 'radio',
                                    'name' => 'columnFloat',
                                    'id' => 'my_class_column_float_3',
                                    'autocomplete' => 'off',
                                    'value' => '',
                                ),
                        ),
                    'columnBool' =>
                        array (
                            'MyClass_columnBool' =>
                                array (
                                    'tag' => 'input',
                                    'type' => 'checkbox',
                                    'name' => 'columnBool',
                                    'id' => 'MyClass_columnBool',
                                    'autocomplete' => 'off',
                                    'value' => '',
                                ),
                        ),
                    'columnDate' =>
                        array (
                            'MyClass_columnDate' =>
                                array (
                                    'tag' => 'input',
                                    'type' => 'checkbox',
                                    'name' => 'columnDate',
                                    'id' => 'MyClass_columnDate',
                                    'autocomplete' => 'off',
                                    'value' => '',
                                ),
                        ),
                    'select2' =>
                        array (
                            'MyClass_select2' =>
                                array (
                                    'options' =>
                                        array (
                                            0 =>
                                                array (
                                                    'value' => '',
                                                    'text' => 'Select',
                                                ),
                                            1 =>
                                                array (
                                                    'value' => '9',
                                                    'text' => 'Option with 9',
                                                ),
                                            2 =>
                                                array (
                                                    'value' => '99',
                                                    'text' => 'Option with 999',
                                                ),
                                        ),
                                    'tag' => 'select',
                                    'name' => 'select2',
                                    'id' => 'MyClass_select2',
                                    'autocomplete' => 'off',
                                    'value' => '',
                                ),
                        ),
                ),
        );
        //</editor-fold>

        Cache::instance()->clearCache();
        $form = Form::parse(new \ReflectionClass(MyClass::class));
        $this->assertInstanceOf(Form::class, $form);
        $array = $form->toStackArray();
        $this->assertSame($expect, $array);
        return $array;
    }

    /**
     * @test
     * @depends test
     *
     * @param array $expect
     *
     * @return void
     * @throws \PChouse\Attributes\HTML\HtmlException
     * @throws \PChouse\Attributes\HTML\Cache\CacheException
     */
    public function testFormCached(array $expect): void
    {
        $form = Form::parse(new \ReflectionClass(MyClass::class));
        $this->assertInstanceOf(CachedForm::class, $form);
        $array = $form->toStackArray();
        $this->assertSame($expect, $array);
    }
}
