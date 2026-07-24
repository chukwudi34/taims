<template>
  <div>
    <div class="CHAT_MESSAGE_POPUPBOX" :class="{ active: open }">
      <div class="CHAT_POPUP_HEADER">
        <div class="MSEESAGE_CHATBOX_CLOSE" @click="open = false">
          <svg width="12" height="12" viewBox="0 0 12 12" fill="none">
            <path d="M7.09939 5.98831L11.772 10.661C12.076 10.965 12.076 11.4564 11.772 11.7603C11.468 12.0643 10.9766 12.0643 10.6726 11.7603L5.99994 7.08762L1.32737 11.7603C1.02329 12.0643 0.532002 12.0643 0.228062 11.7603C-0.0760207 11.4564 -0.0760207 10.965 0.228062 10.661L4.90063 5.98831L0.228062 1.3156C-0.0760207 1.01166 -0.0760207 0.520226 0.228062 0.216286C0.379534 0.0646715 0.578697 -0.0114918 0.777717 -0.0114918C0.976738 -0.0114918 1.17576 0.0646715 1.32737 0.216286L5.99994 4.889L10.6726 0.216286C10.8243 0.0646715 11.0233 -0.0114918 11.2223 -0.0114918C11.4213 -0.0114918 11.6203 0.0646715 11.772 0.216286C12.076 0.520226 12.076 1.01166 11.772 1.3156L7.09939 5.98831Z" fill="white"/>
          </svg>
        </div>
        <h3>Chat with us</h3>
        <div class="Chat_Listed_member" v-if="!activeContact">
          <ul>
            <li v-for="c in contacts" :key="c.id">
              <a href="#" @click.prevent="selectContact(c)">
                <div class="member_thumb">
                  <img :src="c.image ? '/storage/' + c.image : 'https://ui-avatars.com/api/?name=' + c.fname + '+' + c.lname" />
                </div>
              </a>
            </li>
          </ul>
        </div>
      </div>
      <div class="CHAT_POPUP_BODY" v-if="activeContact">
        <div v-for="msg in messages" :key="msg.id" :class="msg.sender_id == userId ? 'CHATING_SENDER CHATING_RECEIVEr' : 'CHATING_SENDER'">
          <div class="SEND_SMS_VIEW"><p>{{ msg.message }}</p></div>
        </div>
        <div v-if="!messages.length" class="text-center text-muted py-3">No messages yet</div>
      </div>
      <div class="CHAT_POPUP_BODY" v-else>
        <p class="text-center text-muted py-3" v-if="contacts.length">Select a contact to start chatting</p>
        <p class="text-center text-muted py-3" v-else>No contacts available</p>
      </div>
      <div class="CHAT_POPUP_BOTTOM" v-if="activeContact">
        <div class="chat_input_box d-flex align-items-center">
          <div class="input-group">
            <input type="text" class="form-control" v-model="newMessage" placeholder="Type a message" @keyup.enter="sendMessage">
            <div class="input-group-append">
              <button class="btn" type="button" @click="sendMessage" :disabled="!newMessage.trim()">
                <i class="fas fa-paper-plane"></i>
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="chat-trigger" @click="toggleChat">
      <i class="fas fa-comment"></i>
      <span class="chat-badge" v-if="unread > 0">{{ unread }}</span>
    </div>
  </div>
</template>
<script>
import axios from "axios";
export default {
  data() {
    return {
      open: false,
      unread: 0,
      contacts: [],
      activeContact: null,
      messages: [],
      newMessage: "",
      userId: null,
      pollInterval: null,
    };
  },
  methods: {
    toggleChat() {
      this.open = !this.open;
      if (this.open) {
        this.fetchContacts();
        this.fetchUnread();
        if (this.activeContact) this.fetchMessages();
        this.startPolling();
      } else {
        this.stopPolling();
      }
    },
    fetchContacts() {
      axios.get("/api/chat/contacts").then((res) => (this.contacts = res.data));
    },
    fetchUnread() {
      axios.get("/api/chat/unread-count").then((res) => (this.unread = res.data.unread));
    },
    selectContact(contact) {
      this.activeContact = contact;
      this.fetchMessages();
    },
    fetchMessages() {
      if (!this.activeContact) return;
      axios.get("/api/chat/messages", { params: { with: this.activeContact.id } }).then((res) => {
        this.messages = res.data;
        this.fetchUnread();
      });
    },
    sendMessage() {
      if (!this.newMessage.trim() || !this.activeContact) return;
      axios
        .post("/api/chat/send", { receiver_id: this.activeContact.id, message: this.newMessage })
        .then((res) => {
          this.messages.push(res.data);
          this.newMessage = "";
        });
    },
    startPolling() {
      this.pollInterval = setInterval(() => {
        if (this.activeContact) this.fetchMessages();
        this.fetchUnread();
      }, 5000);
    },
    stopPolling() {
      if (this.pollInterval) clearInterval(this.pollInterval);
    },
  },
  mounted() {
    this.userId = this.$page.props.auth.user.id;
    this.fetchUnread();
  },
  beforeDestroy() {
    this.stopPolling();
  },
};
</script>
<style scoped>
.chat-trigger {
  position: fixed;
  bottom: 20px;
  right: 20px;
  width: 56px;
  height: 56px;
  border-radius: 50%;
  background: #002147;
  color: #fdc800;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  z-index: 999;
  font-size: 24px;
  box-shadow: 0 4px 12px rgba(0,0,0,0.2);
}
.chat-badge {
  position: absolute;
  top: -5px;
  right: -5px;
  background: #dc3545;
  color: white;
  font-size: 12px;
  width: 22px;
  height: 22px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-weight: bold;
}
.CHAT_MESSAGE_POPUPBOX {
  position: fixed;
  bottom: 90px;
  right: 20px;
  width: 350px;
  max-height: 500px;
  background: white;
  border-radius: 12px;
  box-shadow: 0 8px 24px rgba(0,0,0,0.15);
  display: none;
  z-index: 998;
  overflow: hidden;
}
.CHAT_MESSAGE_POPUPBOX.active {
  display: block;
}
</style>
