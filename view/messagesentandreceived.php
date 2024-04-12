<div class="messages">
    <div class="message received">
        <div class="message-content">
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
            <span class="message-time">10:30 AM</span>
        </div>
    </div>
    <div class="message sent">
        <div class="message-content">
            <p>Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
            <span class="message-time">10:32 AM</span>
        </div>
    </div>
    <!-- More chat messages can be added here -->
</div>


.message {
    display: flex;
    margin-bottom: 10px;
}

.message-content {
    padding: 10px;
    border-radius: 10px;
    max-width: 70%;
}

.message p {
    margin: 0;
}

.message.sent {
    align-self: flex-end;
    background-color: #5959ef;
    color: #fff;
}

.message.received {
    align-self: flex-start;
    background-color: #f1f1f1;
    color: #000;
}

.message-time {
    font-size: 0.8rem;
    color: #777;
}
