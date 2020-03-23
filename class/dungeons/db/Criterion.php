<?php //>

namespace dungeons\db;

interface Criterion {

    function bind($statement, $bindings);

    function make();

}
