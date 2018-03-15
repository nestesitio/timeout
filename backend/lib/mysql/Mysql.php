<?php

namespace lib\mysql;

/**
 * Description of Mysql
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Nov 26, 2014
 */
class Mysql
{
    /** Comparison type. */
    const EQUAL = "=";

    /** Comparison type. */
    const NOT_EQUAL = "<>";

    /** Comparison type. */
    const ALT_NOT_EQUAL = "!=";

    /** Comparison type. */
    const GREATER_THAN = ">";

    /** Comparison type. */
    const LESS_THAN = "<";

    /** Comparison type. */
    const GREATER_EQUAL = ">=";

    /** Comparison type. */
    const LESS_EQUAL = "<=";

    /** Comparison type. */
    const LIKE = " LIKE ";

    /** Comparison type. */
    const NOT_LIKE = " NOT LIKE ";

    /** Comparison type. */
    const DISTINCT = "DISTINCT";

    /** Comparison type. */
    const IN = " IN ";

    /** Comparison type. */
    const NOT_IN = " NOT IN ";

    /** Comparison type. */
    const BETWEEN = " BETWEEN ";

    /** Comparison type. */
    const ALL = "ALL";

    /** Comparison type. */
    const JOIN = "JOIN";

    /** Binary math operator: AND */
    const BINARY_AND = "&";

    /** Binary math operator: OR */
    const BINARY_OR = "|";

    /** "Order by" qualifier - ascending */
    const ASC = "ASC";

    /** "Order by" qualifier - descending */
    const DESC = "DESC";

    /** "IS NULL" null comparison */
    const ISNULL = " IS NULL ";

    /** "IS NOT NULL" null comparison */
    const ISNOTNULL = " IS NOT NULL ";

    /** "LEFT JOIN" SQL statement */
    const LEFT_JOIN = "LEFT JOIN";

    /** "RIGHT JOIN" SQL statement */
    const RIGHT_JOIN = "RIGHT JOIN";

    /** "INNER JOIN" SQL statement */
    const INNER_JOIN = "INNER JOIN";

    /** logical OR operator */
    const LOGICAL_OR = "OR";

    /** logical AND operator */
    const LOGICAL_AND = "AND";

    /** mysql> SELECT DATE_ADD('2008-01-02', INTERVAL 31 DAY); **/
    const DATE_ADD = "DATE_ADD";

    /** mysql> SELECT NOW(); **/
    const NOW = "NOW()";

    /** mysql> search_modifier: AGAINST ('$search' IN NATURAL LANGUAGE MODE) **/
    const SEARCH_NATURAL = "IN NATURAL LANGUAGE MODE";

    /** mysql> search_modifier: AGAINST ('$search' IN NATURAL LANGUAGE MODE WITH QUERY EXPANSION) **/
    const SEARCH_NATURAL_WITH_QUERY = "IN NATURAL LANGUAGE MODE WITH QUERY EXPANSION";

    /** mysql> search_modifier: AGAINST ('$search' IN BOOLEAN MODE) **/
    const SEARCH_BOOLEAN = "IN BOOLEAN MODE";

    /** mysql> SELECT MAX(...); **/
    const FUNCTION_MAX = "MAX";

    /** mysql> SELECT MIN(...); **/
    const FUNCTION_MIN = "MIN";

    /** mysql> ORDER BY RAND(); **/
    const FUNCTION_RAND = "RAND()";


}
