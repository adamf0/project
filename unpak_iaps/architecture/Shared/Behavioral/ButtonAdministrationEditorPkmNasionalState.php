<?php

namespace Architecture\Shared\Behavioral;

class ButtonAdministrationEditorPkmNasionalState extends MappingHtmlOrmStateInterface
{
    public function __construct(public $item, public $type, public $level) {}

    public function handle()
    {
        $tmp = '';
        if ($this->level == "fakultas") {
            $tmp = '<li><a class="dropdown-item" href="' . route('pkmNasional.actionAdmistration', ['action' => 'ke_lppm', 'id' => $this->item->GetId()]) . '">Kirim ke LPPM</a></li>
                    <li><a class="dropdown-item" href="' . route('pkmNasional.actionAdmistration', ['action' => 'ke_pengaju', 'id' => $this->item->GetId()]) . '">Tolak</a></li>
                    <li><a class="dropdown-item" href="' . route('pkmNasional.toDraf', ['id' => $this->item->GetId()]) . '">Draf</a></li>';
        } else if ($this->level == "lppm") {
            $tmp = '<li><a class="dropdown-item" href="' . route('pkmNasional.actionAdmistration', ['action' => 'ke_fakultas', 'id' => $this->item->GetId()]) . '">Kirim ke Fakultas</a></li>
                    <li><a class="dropdown-item" href="' . route('pkmNasional.actionAdmistration', ['action' => 'ke_reviewer', 'id' => $this->item->GetId()]) . '">Kirim ke Reviewer</a></li>
                    <li><a class="dropdown-item" href="' . route('pkmNasional.actionAdmistration', ['action' => 'ke_pengaju', 'id' => $this->item->GetId()]) . '">Tolak</a></li>
                    <li><a class="dropdown-item" href="' . route('pkmNasional.toDraf', ['id' => $this->item->GetId()]) . '">Draf</a></li>';
        }
        $tmp .= '<a class="dropdown-item" href="' . route('pkmNasional.detail', ['id' => $this->item->GetId()]) . '" >detail</a>';

        $this->output = '<a href="' . route('pkmNasional.administration', ['type' => $this->type, 'id_pkm' => $this->item->GetId()]) . '" class="btn btn-info"><i class="bi bi-file-earmark-check"></i></a>';
        $this->output .= '<div class="btn-group">
                            <button type="button" class="btn btn-info dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-three-dots"></i>
                            </button>
                            <ul class="dropdown-menu">' . $tmp . '</ul>
                        </div>';

        return $this;
    }
}
