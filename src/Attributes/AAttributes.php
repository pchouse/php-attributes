<?php
declare(strict_types=1);

namespace PChouse\Attributes;

abstract class AAttributes
{

    private ITranslator|null $translator = null;


    /**
     * @return \PChouse\Attributes\ITranslator|null
     */
    public function getTranslator(): ?ITranslator
    {
        return $this->translator;
    }

    /**
     * @param \PChouse\Attributes\ITranslator|null $translator
     *
     * @return $this
     */
    public function setTranslator(?ITranslator $translator): self
    {
        $this->translator = $translator;
        return $this;
    }
}
