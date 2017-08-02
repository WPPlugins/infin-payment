<!-- infin-payment price field -->
<table> 
    <tr valign="top">
        <th class="metabox_label_column">
            <label for="meta_a">infin-Payment Price (EUR)</label>
        </th>
        <td>
            <input type="text" id="price" name="price" value="<?php echo @get_post_meta($post->ID, 'price', true); ?>" />
        </td>
    </tr>
</table>