const express = require('express');
const cors = require('cors');
const nodemailer = require('nodemailer');
require('dotenv').config();

const app = express();

// Middleware
app.use(cors());
app.use(express.json());

// Настройка почтового транспорта
const transporter = nodemailer.createTransporter({
  host: process.env.SMTP_HOST || 'smtp.yandex.ru',
  port: process.env.SMTP_PORT || 587,
  secure: false,
  auth: {
    user: process.env.SMTP_USER,
    pass: process.env.SMTP_PASS
  }
});

// Маршрут для отправки сообщений
app.post('/api/send-message', async (req, res) => {
  try {
    const { name, phone, email, service, message } = req.body;

    // Валидация
    if (!name || !phone) {
      return res.status(400).json({
        success: false,
        message: 'Имя и телефон обязательны'
      });
    }

    // HTML шаблон письма
    const emailTemplate = `
      <div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;">
        <h2 style="color: #e53935;">Новая заявка с сайта</h2>
        <div style="background: #f8f9fa; padding: 20px; border-radius: 8px;">
          <p><strong>Имя:</strong> ${name}</p>
          <p><strong>Телефон:</strong> ${phone}</p>
          ${email ? `<p><strong>Email:</strong> ${email}</p>` : ''}
          ${service ? `<p><strong>Услуга:</strong> ${service}</p>` : ''}
          ${message ? `<p><strong>Сообщение:</strong> ${message}</p>` : ''}
          <p><strong>Дата:</strong> ${new Date().toLocaleString('ru-RU')}</p>
        </div>
      </div>
    `;

    // Настройки письма
    const mailOptions = {
      from: process.env.SMTP_USER,
      to: process.env.TO_EMAIL || process.env.SMTP_USER,
      subject: `Новая заявка от ${name}`,
      html: emailTemplate
    };

    // Отправка письма
    await transporter.sendMail(mailOptions);

    res.json({
      success: true,
      message: 'Сообщение успешно отправлено'
    });

  } catch (error) {
    console.error('Ошибка отправки:', error);
    res.status(500).json({
      success: false,
      message: 'Ошибка при отправке сообщения'
    });
  }
});

// Health check
app.get('/api/health', (req, res) => {
  res.json({ status: 'OK', timestamp: new Date().toISOString() });
});

const PORT = process.env.PORT || 3000;
app.listen(PORT, () => {
  console.log(`Сервер запущен на порту ${PORT}`);
});