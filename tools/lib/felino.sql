﻿select name,isactive,(select count(*) from adempiere.m_product where m_product_category_id=a.m_product_category_id) from adempiere.m_product_category a