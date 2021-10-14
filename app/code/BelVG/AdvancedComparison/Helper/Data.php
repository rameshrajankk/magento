<?php
/**
 * BelVG LLC.
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the EULA
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://store.belvg.com/BelVG-LICENSE-COMMUNITY.txt
 *
 ********************************************************************
 * @category   BelVG
 * @package    BelVG_AdvancedComparison
 * @copyright  Copyright (c) 2010 - 2016 BelVG LLC. (http://www.belvg.com)
 * @license    http://store.belvg.com/BelVG-LICENSE-COMMUNITY.txt
 */
namespace BelVG\AdvancedComparison\Helper;

use Magento\Checkout\Model\Cart;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    const CONFIG_ENABLED = 'advancedcomparison/settings/enabled';
    const CONFIG_ENABLED_RATING = 'advancedcomparison/settings/enabled_rating';
    protected $_highlightProducts = [];

    public function isEnabled()
    {
        return ($this->scopeConfig->getValue(self::CONFIG_ENABLED)) ? TRUE : FALSE;
    }

    public function isEnabledRating()
    {
        return ($this->scopeConfig->getValue(self::CONFIG_ENABLED_RATING)) ? TRUE : FALSE;
    }

    public function getHighlightIds($items, $attribute)
    {
        $compareMode = $attribute->getCompareMode();
        if (!empty($compareMode)) {
            $compareMode = (int)$compareMode;
            if (in_array($compareMode, array(1, 2))) {
                return $this->getIntIds($compareMode, $items, $attribute);
            }
            if (in_array($compareMode, array(3, 4))) {
                return $this->getTextIds($compareMode, $items, $attribute);
            }
            if (in_array($compareMode, array(5, 6))) {
                $options = $this->getOptions($attribute);
                if(count($options) > 0) {
                    return $this->getSelectIds($compareMode, $items, $attribute,$options);
                }
            }
            if (in_array($compareMode, array(77,78,75,76,79,74))) {
                $options = $this->getOptions($attribute);
                if(count($options) > 0) {
                    return $this->getMSelectIds($compareMode, $items, $attribute,$options);
                }
            }
            if (in_array($compareMode, array(8, 9))) {
                return $this->getDateIds($compareMode, $items, $attribute);
            }
        }
        return array();
    }

    private function getOptions($attribute)
    {
        $optValues = [];
        $options = $attribute->getOptions();
        $index = 0;
        foreach ($options as $option) {
            if ($option->getData('value') != "") {
                $optValues[$option->getData('value')] = $index;
            } else {
                $optValues[0] = -1;
            }
            $index++;
        }
        return $optValues;
    }

    private function getMSelectIds($compareMode, $items, $attribute,$options)
    {
        $id = -1;
        $ids = [];
        $code = $attribute->getAttributeCode();
        if ($compareMode == 75) {
            $value = -1;
            foreach ($items as $item) {
                $max=max(explode(',',$item->getData($code)));
                if (isset($options[$max]) &&
                    $options[$max] > $value) {
                    $value = $options[$max];
                    $id = $item->getId();
                }
            }
            foreach ($items as $item) {
                $max=max(explode(',',$item->getData($code)));
                if (isset($options[$max]) &&
                    $options[$max] == $value)
                    $ids[] = $item->getId();
            }

            if(count($ids) == $items->getSize())
                return array();

            return $ids;
        }
        if ($compareMode == 76) {
            $value = 10000000000000000000;
            foreach ($items as $item) {
                $max=min(explode(',',$item->getData($code)));
                if (isset($options[$max]) &&
                    $options[$max] < $value) {
                    $value = $options[$max];
                    $id = $item->getId();
                }
            }
            foreach ($items as $item) {
                $max=min(explode(',',$item->getData($code)));
                if (isset($options[$max]) &&
                    $options[$max]  == $value)
                    $ids[] = $item->getId();
            }

            if(count($ids) == $items->getSize())
                return array();

            return $ids;
        }
        if ($compareMode == 77) {
            $value = -1;
            foreach ($items as $item) {
                $values = explode(',',$item->getData($code));
                $max = 0;
                foreach ($values as $val)
                    if (isset($options[$val]))
                        $max+=$options[$val];

                if ($max > $value) {
                    $value = $max;
                    $id = $item->getId();
                }
            }

            foreach ($items as $item) {
                $values = explode(',',$item->getData($code));
                $max = 0;
                foreach ($values as $val)
                    if (isset($options[$val]))
                        $max+=$options[$val];
                if($max == $value)
                    $ids[] = $item->getId();
            }

            if(count($ids) == $items->getSize())
                return array();

            return $ids;
        }
        if ($compareMode == 78) {
            $value = 10000000000000000000;
            foreach ($items as $item) {
                $values = explode(',',$item->getData($code));
                $max = 0;
                foreach ($values as $val)
                    if (isset($options[$val]))
                        $max+=$options[$val];

                if ($max < $value) {
                    $value = $max;
                    $id = $item->getId();
                }
            }

            foreach ($items as $item) {
                $values = explode(',',$item->getData($code));
                $max = 0;
                foreach ($values as $val)
                    if (isset($options[$val]))
                        $max+=$options[$val];

                if($max  == $value)
                    $ids[] = $item->getId();
            }

            if(count($ids) == $items->getSize())
                return array();

            return $ids;
        }
        if ($compareMode == 79) {
            $value = -1;
            foreach ($items as $item) {
                $count = count(explode(',',$item->getData($code)));
                if ($count > $value) {
                    $value = $count;
                    $id = $item->getId();
                }
            }

            foreach ($items as $item) {
                $count = count(explode(',',$item->getData($code)));
                if($count == $value)
                    $ids[] = $item->getId();
            }

            if(count($ids) == $items->getSize())
                return array();

            return $ids;
        }
        if ($compareMode == 74) {
            $value = 1000000000000000000;
            foreach ($items as $item) {
                $count = count(explode(',',$item->getData($code)));
                if ($count < $value) {
                    $value = $count;
                    $id = $item->getId();
                }
            }

            foreach ($items as $item) {
                $count = count(explode(',',$item->getData($code)));
                if($count == $value)
                    $ids[] = $item->getId();
            }

            if(count($ids) == $items->getSize())
                return array();

            return $ids;
        }
    }

    private function getSelectIds($compareMode, $items, $attribute,$options)
    {
        $id = -1;
        $ids = [];
        $code = $attribute->getAttributeCode();
        if ($compareMode == 5) {
            foreach ($items as $item) {
                if ($id == -1) {
                    $value = $options[(int)$item->getData($code)];
                    $id = $item->getId();
                }

                if (isset($options[(int)$item->getData($code)]) &&
                    $options[(int)$item->getData($code)] > $value) {
                    $value = $options[(int)$item->getData($code)];
                    $id = $item->getId();
                }
            }
        }

        if ($compareMode == 6) {
            foreach ($items as $item) {
                if ($id == -1) {
                    $value = (int)$item->getData($code);
                    $id = $item->getId();
                }

                if (isset($options[(int)$item->getData($code)]) &&
                    $options[(int)$item->getData($code)] < $value) {
                    $value = $item->getData($code);
                    $id = $item->getId();
                }
            }
        }

        foreach ($items as $item) {
            if (isset($options[(int)$item->getData($code)]) &&
                $options[(int)$item->getData($code)] == $value)
                $ids[] = $item->getId();
        }

        if(count($ids) == $items->getSize())
            return array();

        return $ids;

    }

    private function getIntIds($compareMode, $items, $attribute)
    {
        $id = -1;
        $ids = [];
        $code = $attribute->getAttributeCode();

        if ($compareMode == 1) {
            foreach ($items as $item) {
                if ($id == -1) {
                    $value = (int)$item->getData($code);
                    $id = $item->getId();
                }

                if ((int)$item->getData($code) > $value) {
                    $value = (int)$item->getData($code);
                    $id = $item->getId();
                }
            }
        }

        if ($compareMode == 2) {
            foreach ($items as $item) {
                if ($id == -1) {
                    $value = (int)$item->getData($code);
                    $id = $item->getId();
                }

                if ((int)$item->getData($code) < $value) {
                    $value = $item->getData($code);
                    $id = $item->getId();
                }
            }
        }

        foreach ($items as $item) {
            if ((int)$item->getData($code) == $value)
                $ids[] = $item->getId();
        }

        if(count($ids) == $items->getSize())
            return array();

        return $ids;

    }

    private function getTextIds($compareMode, $items, $attribute)
    {
        $id = -1;
        $ids = [];
        $code = $attribute->getAttributeCode();
        if ($compareMode == 3) {
            foreach ($items as $item) {
                if ($id == -1) {
                    $value = strlen($item->getData($code));
                    $id = $item->getId();
                }
                if (strlen($item->getData($code)) > $value) {
                    $value = strlen($item->getData($code));
                    $id = $item->getId();
                }
            }
        }
        if ($compareMode == 4) {
            foreach ($items as $item) {
                if ($id == -1) {
                    $value = strlen($item->getData($code));
                    $id = $item->getId();
                }
                if (strlen($item->getData($code)) < $value) {
                    $value = strlen($item->getData($code));
                    $id = $item->getId();
                }
            }
        }

        foreach ($items as $item) {
            if (strlen($item->getData($code)) == $value)
                $ids[] = $item->getId();
        }

        if(count($ids) == $items->getSize())
            return array();

        return $ids;
    }

    private function getDateIds($compareMode, $items, $attribute)
    {
        $id = -1;
        $ids = [];
        $code = $attribute->getAttributeCode();
        if ($compareMode == 8) {
            foreach ($items as $item) {
                if ($id == -1) {
                    $value = strtotime($item->getData($code));
                    $id = $item->getId();
                }
                if (strtotime($item->getData($code)) > $value) {
                    $value = strtotime($item->getData($code));
                    $id = $item->getId();
                }
            }
        }
        if ($compareMode == 9) {
            foreach ($items as $item) {
                if ($id == -1) {
                    $value = strtotime($item->getData($code));
                    $id = $item->getId();
                }
                if (strtotime($item->getData($code)) < $value) {
                    $value = strtotime($item->getData($code));
                    $id = $item->getId();
                }
            }
        }

        foreach ($items as $item) {
            if (strtotime($item->getData($code)) == $value)
                $ids[] = $item->getId();
        }

        if(count($ids) == $items->getSize())
            return array();

        return $ids;
    }

    public function getCompareModeValues($attribute)
    {
        $values[0] = __('Disabled');
        switch ($attribute->getData('frontend_input')) {
            case "date":
                $values[8] = __('Bigger date is better');
                $values[9] = __('Smaller date is better');
                break;
            case "multiselect":
                $values[75] = __('Maximum position is better');
                $values[76] = __('Minimum position is better');
                $values[77] = __('Maximum sum of all positions is better');
                $values[78] = __('Minimum sum of all positions is better');
                $values[79] = __('Maximum number of options');
                $values[74] = __('Minimum number of options');
                break;
            case "select":
                $values[5] = __('Maximum position is better');
                $values[6] = __('Minimum position is better');
                break;
            case "textarea":
                $values[3] = __('More latters is better');
                $values[4] = __('Less letters is better');
                break;
            case "text":
                $values[1] = __('Maximum number is the best (provided that field is number)');
                $values[2] = __('Minimum number is the best (provided that field is number)');
                $values[3] = __('More letters is better');
                $values[4] = __('Less letters is better');
                break;
            case "boolean":
            case "price":
                $values[1] = __('Maximum number is the best');
                $values[2] = __('Minimum number is the best');
                break;
        }
        return $values;
    }

    public function incProductHighlight($productId){
        if(isset($this->_highlightProducts[$productId]))
            $this->_highlightProducts[$productId]++;
        else
            $this->_highlightProducts[$productId]=1;
    }

    public  function getProductHighlight($productId) {
        if(isset($this->_highlightProducts[$productId]))
            return $this->_highlightProducts[$productId];
        else
            return 0;
    }

    public function getMaxHighlightIds(){
        $id = -1;
        $ids = [];
        foreach ($this->_highlightProducts as $key=>$val) {
            if ($id == -1) {
                $value = $val;
                $id = $key;
            }

            if ($val > $value) {
                $value = $val;
                $id = $key;
            }
        }
        foreach ($this->_highlightProducts as  $key=>$val) {
            if ($val == $value)
                $ids[] = $key;
        }

        if(count($ids) == count($this->_highlightProducts))
            return array();
        
        return $ids;
    }
}
