<?php

namespace ElaborateCode\JigsawLocalization;

use ElaborateCode\JsonTongue\TongueFacade;
use TightenCo\Jigsaw\Jigsaw;

class LoadLocalization
{
    public function handle(Jigsaw $jigsaw)
    {
        $tongue = new TongueFacade('/lang');

        $jigsaw->setConfig('localization', $tongue->transcribe());
    }
}
