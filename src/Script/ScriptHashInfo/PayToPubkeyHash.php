<?php

namespace BitWasp\Bitcoin\Script\ScriptHashInfo;

use BitWasp\Bitcoin\Crypto\EcAdapter\Key\PublicKeyInterface;
use BitWasp\Bitcoin\Script\Classifier\OutputClassifier;
use BitWasp\Bitcoin\Script\ScriptInterface;

class PayToPubkeyHash implements ScriptInfoInterface
{
    /**
     * @var ScriptInterface
     */
    private $script;

    /**
     * @var \BitWasp\Buffertools\Buffer
     */
    private $hash;

    /**
     * @param ScriptInterface $script
     */
    public function __construct(ScriptInterface $script)
    {
        $this->script = $script;
        $chunks = $this->script->getScriptParser()->parse();
        $this->hash = $chunks[2];
    }

    /**
     * @return string
     */
    public function classification()
    {
        return OutputClassifier::PAYTOPUBKEYHASH;
    }

    /**
     * @return int
     */
    public function getRequiredSigCount()
    {
        return 1;
    }

    /**
     * @return int
     */
    public function getKeyCount()
    {
        return 1;
    }

    /**
     * @param PublicKeyInterface $publicKey
     * @return bool
     */
    public function checkInvolvesKey(PublicKeyInterface $publicKey)
    {
        return $publicKey->getPubKeyHash()->getBinary() === $this->hash->getBinary();
    }

    /**
     * @return PublicKeyInterface[]
     */
    public function getKeys()
    {
        return [];
    }
}
