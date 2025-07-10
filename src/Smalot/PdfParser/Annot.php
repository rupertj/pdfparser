<?php

namespace Smalot\PdfParser;

use Smalot\PdfParser\Element\ElementArray;
use Smalot\PdfParser\Element\ElementMissing;
use Smalot\PdfParser\Element\ElementNull;
use Smalot\PdfParser\Element\ElementXRef;

/**
 * The Annot has in its header:
 *     A, Border, F, Rect, StructParent, SubType and Type.
 *     A's header has S = URI, Type = Action, URI = The URI of the link.
 *     Rect has 4 numeric values.
 *     F is flags!
 */
class Annot extends PDFObject
{
    public function getAction()
    {
        return $this->header->get('A');
    }

    public function getFlags(): int
    {
        return (int) $this->header->get('F')->getContent();
    }

    /**
     * Get where this annotation appears on the page.
     *
     * @return array
     *   Contains four floats.
     */
    public function getRect(): array
    {
        $rect = [];
        foreach ($this->header->get('Rect')->getRawContent() as $coordinate) {
          $rect[] = $coordinate->getContent();
        }
        return $rect;
    }

    public function getSubType(): string
    {
        return $this->header->get('Subtype')->getContent();
    }
}
