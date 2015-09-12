<?php
/**
 * @license   http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 * @copyright Copyright (c) 2014 Zend Technologies USA Inc. (http://www.zend.com)
 */

namespace ZF\Doctrine\QueryBuilder\Filter\ODM;

class OrAndX extends AbstractFilter
{
    public function filter($queryBuilder, $metadata, $option)
    {
        $queryType = 'addAnd';

        if (isset($option['where'])) {
            if ($option['where'] === 'and') {
                $queryType = 'addAnd';
            } elseif ($option['where'] === 'or') {
                $queryType = 'addOr';
            }
        }

        $expr = $queryBuilder->expr();
        
        foreach ($option['conditions'] as $condition) {
            $filter = $this->getFilterManager()->get(
                strtolower($condition['type']),
                array($this->getFilterManager())
            );
            
            $filter->buildExpr($expr, $metadata, $condition);
        }
        
        $queryBuilder->$queryType($expr);
    }
}