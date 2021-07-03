```php
select
  `roles`.*,
  `user_role`.`user_id` as `pivot_user_id`,
  `user_role`.`role_id` as `pivot_role_id`
from
  `roles`
  inner join `user_role` on `roles`.`id` = `user_role`.`role_id`
where
  `user_role`.`user_id` = ?

```

