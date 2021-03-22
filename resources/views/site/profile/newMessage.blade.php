@include("site.inc.header")
<section class="s-chat">
    <div class="container">
        <div class="chat-container chat-empty">
            <div class="left">
                <div class="top-panel top-panel-left">
                    <h2>Messages</h2>
                    <form class="m-search-form">
                        <div class="search-icon">@php(include ("mooimarkt/img/search-icon.svg"))</div>
                        <input type="text" placeholder="Search">
                    </form>
                </div>
                <div class="m-list-items-wrap">
                    <span class="empty-text">No chats yet</span>
                </div>
            </div>
            <div class="right">
                <div class="top-panel top-panel-right">
                    
                </div>
                <div class="messages-box">
                    <div class="messages-content">
                    <span class="empty-text">No messages yet</span>
                    </div>
                    <div class="bottom-controls">
                        <div class="control-left">
                            <div class="img-wrap"><img src="mooimarkt/img/m-img-6.jpg" alt=""></div>
                            <input type="text" class="message-input" placeholder="Type here...">
                        </div>
                        <div class="control-right">
                            <label class="attachment-file-btn">
                                <div class="attachment-file-icon">@php(include ("mooimarkt/img/attachment-icon.svg"))</div>
                                <input type="file" id="MessageFile" accept="image/x-png,image/gif,image/jpeg">
                            </label>
                            <div class="btn-wrap">
                                <button class="btn def_btn btn-send-message">Send</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@include("site.inc.footer")