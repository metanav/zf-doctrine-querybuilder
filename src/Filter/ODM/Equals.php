<?php
/**
 * @license   http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 * @copyright Copyright (c) 2014 Zend Technologies USA Inc. (http://www.zend.com)
 */

namespace ZF\Doctrine\QueryBuilder\Filter\ODM;

class Equals extends AbstractFilter
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
        $this->buildExpr($expr, $metadata, $option);
        $queryBuilder->$queryType($expr, $metadata, $option);
    }
    
    public function buildExpr($expr, $metadata, $option)
    {
        $format = isset($option['format']) ? $option['format'] : null;

        $value = $this->typeCastField($metadata, $option['field'], $option['value'], $format);

        $expr->field($option['field'])->equals($value);
    }
}
