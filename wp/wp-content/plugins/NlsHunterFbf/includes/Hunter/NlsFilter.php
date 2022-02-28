<?php
require_once 'NlsHelper.php';

abstract class Condition
{
  const OR = 'OR';
  const AND = 'AND';
}

abstract class SearchPhrase
{
  const ALL = 'All';
}

class FilterField
{
  public $SearchPhrase;
  public $IncludeEmptyValues;
  public $Value;
  public $Field;
  public $FieldFilterType;
  public $NestedFields;

  public function __construct($field, $searchPhrase, $value, $fieldType = "")
  {
    $this->SearchPhrase = $searchPhrase;
    $this->IncludeEmptyValues = false;
    $this->FieldFilterType = $fieldType;
    $this->Value = $value;
    $this->Field = $field;
  }

  public function setNested($nestedFiled)
  {
    $this->FieldFilterType = 'Nested';
    $this->NestedFields[] = $nestedFiled;
  }
}

class WhereFilter
{
  /**
   * One FilterField
   */
  public $Filters;

  /**
   * One of the Enum class Condition
   */
  public $Condition;

  public function __construct($filters, $condition)
  {
    $this->Filters[] = $filters;
    $this->Condition = $condition;
  }
}

/**
 * Description of NlsFilter
 *
 * @author nurielmeni
 */
class NlsFilter
{
  const NUMERIC_VALUES = 'NumericValues';
  const TEXTUAL_SEARCH  = "TextualSearch";
  const TERMS_NON_ANALAYZED = "TermsNonAnalyzed";
  const DATE_TIME_RANGE = "DateTimeRange";
  const NESTED = "Nested";

  public $GeoSortDescriptor = null;
  public $FromView;
  public $LanguageId;
  public $SelectFilterFields = [];
  public $WhereFilters = [];

  public function __construct($view = 'Jobs')
  {
    $this->FromView = $view;
    $this->LanguageId = NlsHelper::languageCode();
  }

  /**
   * Sets the Supplier Id for the filter
   * @supplierId - The supplier Id for the search
   */
  public function addSuplierIdFilter($supplierId)
  {
    $sidParentFilterField = new FilterField('PublishedJobSupplier', SearchPhrase::ALL, $supplierId, self::NESTED);
    $sidNestedFilterField = new FilterField('PublishedJobSupplier_SupplierId', SearchPhrase::ALL, $supplierId, self::TERMS_NON_ANALAYZED);
    $sidParentFilterField->setNested($sidNestedFilterField);

    $this->addWhereFilter($sidParentFilterField, Condition::AND);
  }

  /**
   * Add select fields for the filter
   * @fields Array || String, names of the select fields
   */
  public function addSelectFilterFields($fields)
  {
    $fieldsArray = !is_array($fields) ? [$fields] : $fields;
    $this->SelectFilterFields = array_merge($this->SelectFilterFields, $fieldsArray);
  }

  /**
   * @filter - the wher filter to add with the specific condition
   * @condition - Condition Class options
   */
  public function addWhereFilter($filters, $condition)
  {
    $whereFilter = new WhereFilter($filters, $condition);
    $this->WhereFilters[] = $whereFilter;
  }

  private function filterWhere()
  {
  }
}
