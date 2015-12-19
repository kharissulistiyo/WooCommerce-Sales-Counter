# WooCommerce Sales Counter Extension

Plugin Name: WooCommerce Sales Counter
Plugin URI: http://risbl.co/wp/woocommerce-sales-counter-extension/
Description: Display WooCommerce product sales counter using a very simple shortcode.
Author: Kharis Sulistiyono
Version: 1.0
Author URI: http://risbl.co/wp

### Basic Setup

```
[risbl_sales_counter]
```

### Optional parameters

* prod_label
* sales_label
* ids
* mode

**prod_label**

Text for product name column heading

**sales_label**

Text for sales counter column heading

**ids**

Filter for specific product IDs, in comma separated value. Example: ids="1,2,3"

**mode**

Display raw counter for single product only. It works with single value of ids parameter. The value must be single_raw i.e. mode="single_raw"

### Usage

```
[risbl_sales_counter ids="1,2,3"]
```
Display product sales counter for products with IDs 1, 2, and 3

```
[risbl_sales_counter ids="1" mode="single_raw"]
```
Display sales counter number for product ID 1 only.
