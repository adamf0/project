<?php
namespace Architecture\Domain\Behavioral;

use Exception;

class RangeRuleMatcher implements RuleMatcher {
    public function match($value, $operator, $target) {
        if( isset($target["min"]) && isset($target["max"]) ){
            $rangeMinValue = $target["min"]["value"];
            $rangeMinOperator = $target["min"]["operator"];
            $rangeMaxValue = $target["max"]["value"];
            $rangeMaxOperator = $target["max"]["operator"];
            
            // dump(
            //     $value,$rangeMinOperator,$rangeMinValue,
            //     $value,$rangeMaxOperator,$rangeMaxValue
            // );
            return $this->toComparison($value,$rangeMinOperator,$rangeMinValue) && $this->toComparison($value,$rangeMaxOperator,$rangeMaxValue);
        } else if( isset($target["min"]) && !isset($target["max"])  ){
            $rangeMinValue = $target["min"]["value"];
            $rangeMinOperator = $target["min"]["operator"];
            
            // dump($value,$rangeMinOperator,$rangeMinValue);
            return $this->toComparison($value,$rangeMinOperator,$rangeMinValue);
        } else if( !isset($target["min"]) && isset($target["max"])  ){
            $rangeMaxValue = $target["max"]["value"];
            $rangeMaxOperator = $target["max"]["operator"];
            
            // dump($value,$rangeMaxOperator,$rangeMaxValue);
            return $value>0 && $this->toComparison($value,$rangeMaxOperator,$rangeMaxValue);
        } else{
            throw new Exception("RangeRuleMatcher is broken");
        }
    }

    function toComparison($value,$operator,$target){
        return match($operator){
            ">"=>$value>$target,
            ">="=>$value>=$target,
            "=="=>$value==$target,
            "!="=>$value!=$target,
            "<"=>$value<$target,
            "<="=>$value<=$target,
            default=>throw new Exception("invalid operator comparison")
        };
    }
}