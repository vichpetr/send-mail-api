<?php

namespace petrvich\sendmail\dto;

class Audit {

    private int $id;
    private \DateTime $timestamp;
    private Template $template;

    /**
     * Audit constructor.
     * @param Template $template
     */
    public function __construct(Template $template)
    {
        $this->template = $template;
        $this->timestamp = new \DateTime();
    }

    /**
     * @return \DateTime
     */
    public function getTimestamp(): \DateTime
    {
        return $this->timestamp;
    }

    /**
     * @return Template
     */
    public function getTemplate(): Template
    {
        return $this->template;
    }
}
