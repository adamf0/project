<?php
namespace Architecture\Domain\Behavioral;

class DefaultMatcher implements RuleMatcher {
    public function match($value, $operator, $target) {
        return $value;
    }
}