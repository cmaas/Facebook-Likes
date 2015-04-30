Extended the original script to make all stats returned by Facebook's API sortable. Also, now reads URLs from a file in the example.

### Use Cases

Can be used as a "proxy" script. Just run via cron, save the stats somewhere and display the `like_count`, `share_count` or `total_count`. This way, Facebook isn't directly linked via JS to your website and thus, doesn't track the users.

Also, can be used to display the counter conditionally. An article with 0 shares/likes has negative social proof.

> Nobody liked this article so far? Then it's probably not good.

You could show the counter only if it is > $THRESHOLD. Then the user might think:

> Oh, this already has 50 shares, I might share it as well.
