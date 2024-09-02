<?php
    $meta = get_post_meta( $post->ID );
    $link_text = get_post_meta( $post->ID, 'mv_imagetext_link_text', true );
    $link_url = get_post_meta( $post->ID, 'mv_imagetext_link_url', true );
    //var_dump( $link_text, $link_url );?>

<table class="form-table mv-imagetext-metabox"> 
    <input type="hidden" name="my_imagetext_nonce" value="<?php echo wp_create_nonce('my_imagetext_nonce') ?>">
    <tr>
        <th>
            <label for="mv_imagetext_link_text">Link Text</label>
        </th>
        <td>
            <input 
                type="text" 
                name="mv_imagetext_link_text" 
                id="mv_imagetext_link_text" 
                class="regular-text link-text"
                value="<?php echo ( isset( $link_text ) ) ? esc_html( $link_text ) : ''; ?>"
                required
                >
            </td>
            <!-- value="<?php /* echo $meta["mv_slider_link_text"][0] */?>"  -->
    </tr>
    <tr>
        <th>
            <label for="mv_imagetext_link_url">Link URL</label>
        </th>
        <td>
            <input 
                type="url" 
                name="mv_imagetext_link_url" 
                id="mv_imagetext_link_url" 
                class="regular-text link-url"
                value="<?php echo ( isset( $link_url ) ) ? esc_url( $link_url ) : ''; ?>"
                required
                >
                <!-- value="<?php /* echo $meta["mv_slider_link_url"][0] */ ?>" -->
        </td>
    </tr>               
</table>