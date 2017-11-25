Indentation error, I'll fix it in other versions

Attributes

Installation Steps:
- Extract extension zip file
- Move all the files to your Magento 2 root directory > app > code > Bhartendukumar > Attribute directory.
- Run following commands from the root directory of your Magento 2.
- php bin/magento module:enable Bhartendukumar_Attribute (enable the extension)
- php bin/magento setup:upgrade (Update database for this new extension)
- php bin/magento setup:static-content:deploy en_US
- php bin/magento cache:clean (clean the cache)
You are done.

How it works?
Using this extension you can add different types of custom attributes of Category, Customer and Customer Address.After successfully follow installation steps, New admin menu BHARTENDUKUMAR available in the admin.

Category Attributes:
- To add a new category attribute go to Admin > BHARTENDUKUMAR > Attribute Manager > Category
- Added custom category attributes list display here.
- Custom attributes of category is display on admin category form to add/update details.
- Also if you need that details on frontend than you can load category by its model and can get that category attribute details.

Customer Attributes:
- To add a new customer attribute go to Admin > BHARTENDUKUMAR > Attribute Manager > Customer
- Added custom customer attributes list display here.
- Custom attributes of customer are automatically display on frontend on customer register and customer account edit page if “Show on Storefront” option is set to “Yes” when add a attribute. Also it is available to admin customer form to add/update details.

Customer Address Attributes:
- To add a new customer address attribute goto Admin > BHARTENDUKUMAR > Attribute Manager > Customer Address
- Added custom customer address attributes list display here.
- Custom attributes of customer address are automatically display on frontend on customer register and customer my account address page if “Show on Storefront”
option is set to “Yes” when add a attribute. Also it is available to admin customer address form to add/update details.
