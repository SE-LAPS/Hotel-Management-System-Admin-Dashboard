<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Hotel Management Chatbot</title>
    <!-- Add Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .chatbot-toggler {
            position: fixed;
            bottom: 30px;
            right: 35px;
            outline: none;
            border: none;
            height: 50px;
            width: 50px;
            display: flex;
            cursor: pointer;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background:linear-gradient(69.66deg, #7f00fe 19.39%, #daf0ff 96.69%);
            transition: all 0.2s ease;
        }
        body.show-chatbot .chatbot-toggler {
            transform: rotate(90deg);
        }
        .chatbot-toggler i {
            color: #fff;
            font-size: 24px;
        }
        body.show-chatbot .chatbot-toggler .bi-chat-dots {
            display: none;
        }
        body.show-chatbot .chatbot-toggler .bi-robot {
            display: block;
        }
        .chatbot-toggler .bi-robot {
            display: none;
        }
        .chatbot {
            position: fixed;
            right: 35px;
            bottom: 90px;
            width: 360px;
            max-width: 90%;
            background: #fff;
            border-radius: 15px;
            overflow: hidden;
            opacity: 0;
            pointer-events: none;
            transform: scale(0.5);
            transform-origin: bottom right;
            box-shadow: 0 0 128px 0 rgba(0,0,0,0.1),
                        0 32px 64px -48px rgba(0,0,0,0.5);
            transition: all 0.2s ease;
        }
        body.show-chatbot .chatbot {
            opacity: 1;
            pointer-events: auto;
            transform: scale(1);
        }
        .chatbot header {
            padding: 16px 0;
            position: relative;
            text-align: center;
            color: #fff;
            background: linear-gradient(to left, #0acffe 0%, #4400fe 100%); 
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .chatbot header span {
            position: absolute;
            right: 15px;
            top: 50%;
            display: none;
            cursor: pointer;
            transform: translateY(-50%);
        }
        header h2 {
            font-size: 1.4rem;
        }
        .chatbot .chatbox {
            overflow-y: auto;
            height: 400px;
            padding: 20px 15px 80px;
        }
        .chatbox .chat {
            display: flex;
            list-style: none;
        }
        .chatbox .outgoing {
            margin: 20px 0;
            justify-content: flex-end;
        }
        .chatbox .incoming i {
            width: 32px;
            height: 32px;
            color: #fff;
            cursor: default;
            text-align: center;
            line-height: 32px;
            align-self: flex-end;
            background: #0056b3;
            border-radius: 4px;
            margin: 0 10px 7px 0;
        }
        .chatbox .chat p {
            white-space: pre-wrap;
            padding: 12px 16px;
            border-radius: 10px 10px 0 10px;
            max-width: 75%;
            color: #fff;
            font-size: 0.95rem;
            background: #0056b3;
        }
        .chatbox .incoming p {
            border-radius: 10px 10px 10px 0;
        }
        .chatbox .chat p.error {
            color: #721c24;
            background: #f8d7da;
        }
        .chatbox .incoming p {
            color: #000;
            background: #f2f2f2;
        }
        .chatbot .chat-input {
            display: flex;
            gap: 5px;
            position: absolute;
            bottom: 0;
            width: 100%;
            background: #fff;
            padding: 3px 20px;
            border-top: 1px solid #ddd;
        }
        .chat-input textarea {
            height: 55px;
            width: 100%;
            border: none;
            outline: none;
            resize: none;
            max-height: 180px;
            padding: 15px 15px 15px 0;
            font-size: 0.95rem;
        }
        .chat-input span {
            align-self: flex-end;
            color: #0056b3;
            cursor: pointer;
            height: 55px;
            display: flex;
            align-items: center;
            visibility: hidden;
            font-size: 1.35rem;
        }
        .chat-input textarea:valid ~ span {
            visibility: visible;
        }

        @media (max-width: 768px) {
            .chatbot-toggler {
                right: 20px;
                bottom: 20px;
            }
            .chatbot {
                right: 20px;
                bottom: 20px;
                width: 320px;
            }
        }
        @media (max-width: 490px) {
            .chatbot-toggler {
                right: 20px;
                bottom: 20px;
            }
            .chatbot {
                right: 0;
                bottom: 0;
                height: 100%;
                border-radius: 0;
                width: 100%;
            }
            .chatbot .chatbox {
                height: 90%;
                padding: 25px 15px 100px;
            }
            .chatbot .chat-input {
                padding: 5px 15px;
            }
            .chatbot header span {
                display: block;
            }
        }
    </style>
</head>
<body>
    <button class="chatbot-toggler">
        <i class="bi bi-chat-dots"></i>
        <i class="bi bi-robot"></i>
    </button>
    <div class="chatbot">
        <header>
            <h2>Hotel Chatbot</h2>
            <span class="close-btn material-symbols-outlined">close</span>
        </header>
        <ul class="chatbox">
            <li class="chat incoming">
                <i class="bi bi-robot"></i>
                <p>Welcome to our Hotel! 👋<br>How can I assist you today?</p>
            </li>
        </ul>
        <div class="chat-input">
            <textarea placeholder="Enter a message..." spellcheck="false" required></textarea>
            <span id="send-btn" class="material-symbols-rounded">send</span>
        </div>
    </div>
    <script>
        const chatbotToggler = document.querySelector(".chatbot-toggler");
        const closeBtn = document.querySelector(".close-btn");
        const chatbox = document.querySelector(".chatbox");
        const chatInput = document.querySelector(".chat-input textarea");
        const sendChatBtn = document.querySelector(".chat-input span");

        let userMessage = null; 
        let waitingForDays = false;
        const inputInitHeight = chatInput.scrollHeight;

        const createChatLi = (message, className) => {
            const chatLi = document.createElement("li");
            chatLi.classList.add("chat", `${className}`);
            let chatContent = className === "outgoing" ? `<p></p>` : `<i class="bi bi-robot"></i><p></p>`;
            chatLi.innerHTML = chatContent;
            chatLi.querySelector("p").textContent = message;
            return chatLi; 
        }

        const initialAnswer = [
            "We offer various room types including Standard, Deluxe, and Suite. Each room is equipped with modern amenities for a comfortable stay.",
            "Our check-in time is 3:00 PM and check-out time is 11:00 AM. Early check-in and late check-out can be arranged based on availability.",
            "Yes, we have an on-site restaurant serving breakfast, lunch, and dinner. We also offer 24-hour room service.",
            "Our hotel features a fitness center, swimming pool, spa, and business center. We also provide free Wi-Fi throughout the property.",
            "We offer airport shuttle services. Please contact our concierge for arrangements and pricing.",
            "Yes, we have conference rooms and event spaces available for business meetings and social events. Contact our events team for more information.",
            "We accept all major credit cards, including Visa, MasterCard, and American Express. Cash payments are also accepted.",
            "Yes, you can book a tour at our concierge desk. We offer various city tours and excursions.",
            "For calculating the room rate, please enter the number of nights you want to book.",
            "Please enter the number of nights you want to book:"
        ];

        const generateResponse = (chatElement, userMessage) => {
            const messageElement = chatElement.querySelector("p");

            if (waitingForDays) {
                let nights = parseInt(userMessage);
                if (!isNaN(nights) && nights > 0) {
                    let baseRate = 100; // Base rate per night
                    let totalCost = nights * baseRate;
                    if (nights >= 7) {
                        totalCost *= 0.9; // 10% discount for stays of 7 nights or more
                    }
                    messageElement.textContent = `For ${nights} night(s), the total cost is $${totalCost.toFixed(2)}. ${nights >= 7 ? "A 10% discount has been applied." : ""}`;
                    waitingForDays = false;
                } else {
                    messageElement.textContent = "Please enter a valid number of nights.";
                }
            } else {
                let index = parseInt(userMessage) - 1;
                if (index >= 0 && index < initialAnswer.length) {
                    messageElement.textContent = initialAnswer[index];
                    if (index === 9) {
                        waitingForDays = true;
                    }
                } else {
                    messageElement.textContent = "Invalid option. Please enter a number from 1 to 10.";
                    messageElement.classList.add("error");
                }
            }
        }

        const handleChat = () => {
            userMessage = chatInput.value.trim();
            if (!userMessage) return;

            chatInput.value = "";
            chatInput.style.height = `${inputInitHeight}px`;

            chatbox.appendChild(createChatLi(userMessage, "outgoing"));
            chatbox.scrollTo(0, chatbox.scrollHeight);

            setTimeout(() => {
                const incomingChatLi = createChatLi("Thinking...", "incoming");
                chatbox.appendChild(incomingChatLi);
                chatbox.scrollTo(0, chatbox.scrollHeight);
                generateResponse(incomingChatLi, userMessage);
            }, 600);
        }

        chatInput.addEventListener("input", () => {
            chatInput.style.height = `${inputInitHeight}px`;
            chatInput.style.height = `${chatInput.scrollHeight}px`;
        });

        chatInput.addEventListener("keydown", (e) => {
            if (e.key === "Enter" && !e.shiftKey && window.innerWidth > 800) {
                e.preventDefault();
                handleChat();
            }
        });

        sendChatBtn.addEventListener("click", handleChat);
        closeBtn.addEventListener("click", () => document.body.classList.remove("show-chatbot"));
        chatbotToggler.addEventListener("click", () => {
            document.body.classList.toggle("show-chatbot");

            if (document.body.classList.contains("show-chatbot")) {
                const initialQuestions = [
                    "1. What types of rooms do you offer?",
                    "2. What are your check-in and check-out times?",
                    "3. Do you have on-site dining options?",
                    "4. What amenities does the hotel provide?",
                    "5. Do you offer airport transfers?",
                    "6. Are there facilities for business meetings or events?",
                    "7. What payment methods do you accept?",
                    "8. Can I book tours through the hotel?",
                    "9. How can I calculate the room rate?",
                    "10. How can I calculate the room rate?"
                ];

                chatbox.innerHTML = "";

                initialQuestions.forEach((question) => {
                    const initialQuestionLi = createChatLi(question, "incoming");
                    chatbox.appendChild(initialQuestionLi);
                });
            }
        });
    </script>
</body>
</html>