<div id="gks-video-dialog" style="display:none;">
    <form action="" id="gks-add-video-form">
        <div class="gks-dialog-form-container">
            <label>Choose video:</label>
            <button id="gks-video-browse" class="gks-glazzed-btn gks-glazzed-btn-green" onclick="onGksVideoBrowse();return false;">Browse</button>
            <br>
            <div id="gks-video-thumb-block" class="gks-fl">
                <label>Thumbnail:</label>
                <div class="gks-dialog-thumb-radio">
                    <input type="radio" name="thumb" value="video" checked="checked" onchange="onVideoThumbTypeChange(this)" />Video
                </div>
                <div class="gks-dialog-thumb-radio">
                    <input type="radio" name="thumb" value="custom" onchange="onVideoThumbTypeChange(this)"/>Custom
                </div>
                <input type="hidden" id="gks-video-thumb-val" value="">
                <input type="hidden" id="gks-video-data-val" value="">
            </div>
            <div id="gks-video-preview" class="gks-fr"></div>
        </div>
        <div style="clear:both;"></div>
        <div class="gks-dialog-btns">
            <button class="gks-glazzed-btn gks-glazzed-btn-dark gks-close-btn">Cancel</button>
            <input class="gks-fr gks-glazzed-btn gks-glazzed-btn-green" type="submit" value="OK" />
            <div style="clear:both;"></div>
        </div>
    </form>
</div>

<div id="gks-iframe-dialog" style="display:none;">
    <form action="" id="gks-add-iframe-form">
        <div class="gks-dialog-form-container">
            <label>Iframe source url:</label>
            <input type="text" required placeholder="Enter source url" value="" id="gks-iframe-src-val">
            <div class="gks-dialog-warning">* Make sure the source allows iFrame embedding!</div>
            <div id="gks-iframe-thumb-block" class="gks-fl">
                <label>Thumbnail:</label>
                <div class="gks-dialog-thumb-radio">
                    <input type="radio" name="thumb" value="iframe" checked="checked" onchange="onIframeThumbTypeChange(this)" />Default
                </div>
                <div class="gks-dialog-thumb-radio">
                    <input type="radio" name="thumb" value="custom" onchange="onIframeThumbTypeChange(this)"/>Custom
                </div>
                <input type="hidden" id="gks-iframe-thumb-val" value="">
            </div>
            <div id="gks-iframe-preview" class="gks-fr"></div>
        </div>
        <div style="clear:both;"></div>
        <div class="gks-dialog-btns">
            <button class="gks-glazzed-btn gks-glazzed-btn-dark gks-close-btn">Cancel</button>
            <input class="gks-fr gks-glazzed-btn gks-glazzed-btn-green" type="submit" value="OK" />
            <div style="clear:both;"></div>
        </div>
    </form>
</div>

<div id="gks-youtube-dialog" style="display:none;">
    <form action="" id="gks-add-youtube-form">
        <div class="gks-dialog-form-container">
            <label>Youtube url:</label>
            <input type="text" required placeholder="Enter youtube id" value="" id="gks-youtube-id-val">
            <div id="gks-youtube-thumb-block" class="gks-fl">
                <label>Thumbnail:</label>
                <div class="gks-dialog-thumb-radio">
                    <input type="radio" name="thumb" value="youtube" checked="checked" onchange="onYoutubeThumbTypeChange(this)" />Youtube
                </div>
                <div class="gks-dialog-thumb-radio">
                    <input type="radio" name="thumb" value="custom" onchange="onYoutubeThumbTypeChange(this)"/>Custom
                </div>
                <input type="hidden" id="gks-youtube-thumb-val" value="">
            </div>
            <div id="gks-youtube-preview" class="gks-fr"></div>
        </div>
        <div style="clear:both;"></div>
        <div class="gks-dialog-btns">
            <button class="gks-glazzed-btn gks-glazzed-btn-dark gks-close-btn">Cancel</button>
            <input class="gks-fr gks-glazzed-btn gks-glazzed-btn-green" type="submit" value="OK" />
            <div style="clear:both;"></div>
        </div>
    </form>
</div>

<div id="gks-vimeo-dialog" style="display:none;">
    <form action="" id="gks-add-vimeo-form">
        <div class="gks-dialog-form-container">
            <label>Vimeo url:</label>
            <input type="text" required placeholder="Enter vimeo id" value="" id="gks-vimeo-id-val">
            <div id="gks-vimeo-thumb-block" class="gks-fl">
                <label>Thumbnail:</label>
                <div class="gks-dialog-thumb-radio">
                    <input type="radio" name="thumb" value="vimeo" checked="checked" onchange="onVimeoThumbTypeChange(this)" />Vimeo
                </div>
                <div class="gks-dialog-thumb-radio">
                    <input type="radio" name="thumb" value="custom" onchange="onVimeoThumbTypeChange(this)"/>Custom
                </div>
                <input type="hidden" id="gks-vimeo-thumb-val" value="">
            </div>
            <div id="gks-vimeo-preview" class="gks-fr"></div>
        </div>
        <div style="clear:both;"></div>
        <div class="gks-dialog-btns">
            <button class="gks-glazzed-btn gks-glazzed-btn-dark gks-close-btn">Cancel</button>
            <input class="gks-fr gks-glazzed-btn gks-glazzed-btn-green" type="submit" value="OK" />
            <div style="clear:both;"></div>
        </div>
    </form>
</div>
