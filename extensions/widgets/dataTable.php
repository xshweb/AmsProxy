<?php
class dataTable extends CWidget {
    /**
     * @var array
     */
    public $data = array();

    /**
     * @var bool
     */
    public $isCollapse = true;

    protected $thead = array();
    protected $tbody = array();

    public function run() {
        $this->thead = $this->data->thead;
        $this->tbody = isset(
            $this->data->tbody) ? $this->data->tbody : null;

        if ($this->isCollapse)
            $this->echoPanel();
        else
            $this->echoTable();
    }

    protected function echoTable() {
        echo '<div class="article table-responsive">';
        $this->openTable();
        $this->echoThead();
        echo '<tbody>';
        foreach ( $this->tbody as $tbody ) {
            $this->echoTrs($tbody);
        }
        echo '</tbody>';
        $this->closeTable();
        echo '</div>';

    }

    protected function echoPanel() {
        if (isset($this->tbody)) {
            echo '<div class="panel-group accordion">';
            $tbodys = array_keys((array)$this->tbody);
            $last_collapse_name = $tbodys[count($tbodys) - 1];
            foreach ($this->tbody as $title => $tbody) {

                $this->openPanel(
                    $title,
                    $last_collapse_name == $title
                );

                $this->openTable();
                $this->echoThead();
                $this->echoTbody($tbody);
                $this->closeTable();

                $this->closePanel();
            }
            echo '</div>';
        }
    }

    protected function openPanel($title, $is_last) {
        echo '<div class="panel">';
        // title
        echo '<div class="panel-heading">';
        echo '<h4 class="panel-title">';
        echo CHtml::link($title, "#{$title}", array(
            'class' => 'accordion-toggle '
                . (!$is_last ? 'collapsed' : ''),
            'data-toggle' => 'collapse',
            'data-parent' => '.panel-group',
        ));
        echo '</h4>';
        echo '</div>';
        // endtitle

        // body
        echo CHtml::openTag('div', array(
            'id' => $title,
            'class' => 'panel-collapse collapse '
                . ($is_last ? 'in' : ''),
        ));
        echo '<div class="panel-body table-responsive">';
    }

    protected function closePanel() {
        echo '</div>';
        echo '</div>';
        // endbody

        echo '</div>';
    }

    protected function openTable() {
        echo '<table class="table table-hover table-striped">';
    }

    protected function closeTable() {
        echo '</table>';
    }

    protected function echoThead() {
        echo '<thead>';
        echo '<tr>';
        foreach ($this->thead as $th)
            echo "<th>{$th}</th>";
        echo '</tr>';
        echo '</thead>';
    }

    protected function echoTbody($tbody) {
        echo '<tbody>';
        $this->echoTrs($tbody);
        echo '</tbody>';
    }

    protected function echoTrs($trs) {
        foreach ($trs as $row) {
            echo CHtml::openTag('tr', 
                isset($row['state']) && $row['state'] == false ?
                array('class' => 'danger') : array()
            );

            foreach ($row as $key => $td) {
                if (is_int($key))
                    echo "<td>$td</td>";
            }
            echo CHtml::closeTag('tr');
        }
    }
}
