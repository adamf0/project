<?php
namespace Architecture\Domain\Behavioral;

use Exception;

class RuleProcessor {
    private $context;

    public function __construct() {
        $this->context = new RuleContext();
    }

    public function checkRule($rules, $input) {
        try {
            $rules = $rules->map(function($rule) use($input){
                $results = collect([]);
                if(!array_key_exists('rules',$rule)) throw new Exception("rule statement is not found");

                foreach ($rule['rules'] as $key => $item) {
                    if (!array_key_exists($key,$input)) {
                        continue;
                    }

                    // if($key=="sinta"){
                    //     $L = $item["operator"]=="default"? $item["default"]:$input[$key];
                    //     $R = isset($item["value"])? $item["value"]:null;

                    //     dd(
                    //         $key, //key rule
                    //         $item, //key array rule
                    //         $item["operator"], //rule operation
                    //         $L, //input,
                    //         $R, 
                    //     );
                    // }

                    // if($item["operator"]=="range"){
                    //     $L = $item["operator"]=="default"? $item["default"]:$input[$key];
                    //     $R = isset($item["value"])? $item["value"]:null;

                    //     dd(
                    //         $key, //key rule
                    //         $item, //key array rule
                    //         $item["operator"], //rule operation
                    //         $L, //input,
                    //         $R, 
                    //     );
                    // }
                    $this->context->setStrategy(match(true){
                        $item["operator"]=="in" => new InRuleMatcher(),
                        $item["operator"]=="or" && is_array($item["value"]) => new OrRuleMatcher(),
                        $item["operator"]=="and" && is_string($item["value"]) => new AndRuleMatcher(),
                        $item["operator"]=="range" => new RangeRuleMatcher(),
                        $item["operator"]=="default" => new DefaultMatcher(),
                        default => throw new Exception("invalid operator")
                    });

                    // dd(
                    //     $key, //key rule
                    //     $item, //key array rule
                    //     $item["operator"], //rule operation
                    //     $input[$key], //input,
                    //     $item["value"], 
                    // );
                    $L = $item["operator"]=="default"? $item["default"]:$input[$key];
                    if($item["operator"]=="and" && in_array(strtolower($L), ["asisten ahli","dosen (tenaga pengajar)"])){
                        $L = "Tenaga Pengajar dan Asisten Ahli";
                    }
                    if($item["operator"]=="and" && in_array(strtolower($L), ["profesor"])){
                        $L = "Guru Besar";
                    }
                    $R = isset($item["value"])? $item["value"]:null;

                    $statement = $this->context->matchRule($L, $item["operator"], $R);
                    $results->push((int) $statement);
                }
                $rule['state'] = $results;
                return $rule;
            });
            $availableRules = $rules->filter(function ($item) {
                return $item['state']->sum()==2;
            })->values();
            
            return $availableRules;
        } catch (Exception $e) {
            throw $e;
        }
    }
}
