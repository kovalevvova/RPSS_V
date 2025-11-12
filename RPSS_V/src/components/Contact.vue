<template>
  <section id="contacts" class="contact-section">
    <div class="container">
      <div class="section-header">
        <h2 class="section-title">Свяжитесь с нами</h2>
        <p class="section-subtitle">Мы всегда готовы ответить на ваши вопросы</p>
      </div>
      <div class="contact-container">
        <div class="contact-info">
          <div class="contact-card">
            <h3><i class="fas fa-map-marker-alt"></i> Наш адрес</h3>
            <p>
              Республика Коми, Усинск р-н,<br>
              г. Усинск, Промышленная ул,<br>
              д. 19, офис 35 (2 этаж)
            </p>
          </div>
          <div class="contact-card">
            <h3><i class="fas fa-phone"></i> Телефоны</h3>
            <div class="phones">
              <a href="tel:+78214452041">+7(82144) 52-0-41</a>
              <a href="tel:+78214452051">+7(82144) 52-0-51</a>
              <a href="tel:+79129564474">8 912 95 644 74</a>
            </div>
          </div>
          <div class="contact-card">
            <h3><i class="fas fa-envelope"></i> Email</h3>
            <a href="mailto:rpss-2017@mail.ru">rpss-2017@mail.ru</a>
          </div>
          <div class="contact-card">
            <h3><i class="far fa-clock"></i> Время работы</h3>
            <p>Пн-Пт: 8:30-17:00<br>Сб-Вс: выходные</p>
          </div>
          <div class="contact-card">
            <h3><i class="fas fa-truck"></i> Зона обслуживания</h3>
            <p>Мы работаем по Усинску и Усинскому району. Возможен выезд в другие районы Республики Коми для крупных объектов.</p>
          </div>
        </div>
        <div class="contact-form-wrapper">
          <div class="contact-form-card">
            <h3>Оставьте заявку</h3>
            <p>Мы перезвоним вам в течение рабочего дня</p>

            <!-- Сообщения о статусе отправки -->
            <div
              v-if="showMessage"
              class="form-message"
              :class="messageType"
            >
              {{ messageText }}
            </div>

            <form @submit.prevent="submitForm">
              <div class="form-group">
                <input
                  type="text"
                  id="name"
                  v-model="form.name"
                  placeholder=" "
                  required
                  :disabled="loading"
                >
                <label for="name">Ваше имя *</label>
                <div class="error-message" v-if="errors.name">{{ errors.name }}</div>
              </div>

              <div class="form-group">
                <input
                  type="tel"
                  id="phone"
                  v-model="form.phone"
                  placeholder=" "
                  required
                  :disabled="loading"
                >
                <label for="phone">Ваш телефон *</label>
                <div class="error-message" v-if="errors.phone">{{ errors.phone }}</div>
              </div>

              <div class="form-group">
                <input
                  type="email"
                  id="email"
                  v-model="form.email"
                  placeholder=" "
                  :disabled="loading"
                >
                <label for="email">Ваш e-mail</label>
                <div class="error-message" v-if="errors.email">{{ errors.email }}</div>
              </div>

              <div class="form-group">
                <select
                  id="object_type"
                  v-model="form.object_type"
                  required
                  :disabled="loading"
                >
                  <option value="" disabled selected>Выберите тип объекта</option>
                  <option value="apartment">Квартира</option>
                  <option value="house">Частный дом</option>
                  <option value="office">Офис</option>
                  <option value="commercial">Коммерческое помещение</option>
                  <option value="other">Другое</option>
                </select>
                <label for="object_type">Тип объекта *</label>
                <div class="error-message" v-if="errors.object_type">{{ errors.object_type }}</div>
              </div>

              <div class="form-group">
                <textarea
                  id="message"
                  v-model="form.message"
                  placeholder=" "
                  rows="4"
                  :disabled="loading"
                ></textarea>
                <label for="message">Сообщение</label>
              </div>

              <button
                type="submit"
                class="btn-form"
                :disabled="loading"
                :class="{ 'loading': loading }"
              >
                <template v-if="loading">
                  <i class="fas fa-spinner fa-spin"></i>
                  Отправка...
                </template>
                <template v-else>
                  <i class="fas fa-paper-plane"></i>
                  Отправить заявку
                </template>
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
import { ref, reactive } from 'vue'

export default {
  name: 'Contact',
  setup() {
    const form = reactive({
      name: '',
      phone: '',
      email: '',
      object_type: '',
      message: ''
    })

    const errors = reactive({})
    const loading = ref(false)
    const showMessage = ref(false)
    const messageText = ref('')
    const messageType = ref('')

    // URL для отправки заявки - ЗАМЕНИТЕ НА СВОЙ URL
    const API_URL = 'http://localhost:8000' // Замените на URL где лежит PHP файл
    // Для тестирования на localhost:
    // const API_URL = 'http://localhost:8000'

    const validateEmail = (email) => {
      if (!email) return true // email не обязателен
      const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/
      return re.test(email)
    }

    const validatePhone = (phone) => {
      const cleaned = phone.replace(/[^\d+]/g, '')
      const digits = cleaned.replace(/\D/g, '')
      return digits.length >= 10 && digits.length <= 15
    }

    const validateForm = () => {
      // Очищаем предыдущие ошибки
      Object.keys(errors).forEach(key => delete errors[key])

      // Валидация имени
      if (!form.name.trim()) {
        errors.name = 'Пожалуйста, введите ваше имя'
      } else if (form.name.trim().length < 2) {
        errors.name = 'Имя должно содержать минимум 2 символа'
      }

      // Валидация телефона
      if (!form.phone.trim()) {
        errors.phone = 'Пожалуйста, введите номер телефона'
      } else if (!validatePhone(form.phone)) {
        errors.phone = 'Пожалуйста, введите корректный номер телефона'
      }

      // Валидация email
      if (form.email && !validateEmail(form.email)) {
        errors.email = 'Пожалуйста, введите корректный email'
      }

      // Валидация типа объекта
      if (!form.object_type) {
        errors.object_type = 'Пожалуйста, выберите тип объекта'
      }

      return Object.keys(errors).length === 0
    }

    const showNotification = (text, type = 'success') => {
      messageText.value = text
      messageType.value = type
      showMessage.value = true

      setTimeout(() => {
        showMessage.value = false
      }, 5000)
    }

    const submitForm = async () => {
      if (!validateForm()) {
        showNotification('Пожалуйста, исправьте ошибки в форме', 'error')
        return
      }

      loading.value = true

      try {
        const response = await fetch(`${API_URL}/send-mail.php`, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify({
            name: form.name.trim(),
            phone: form.phone.trim(),
            email: form.email.trim(),
            object_type: form.object_type,
            message: form.message.trim()
          })
        })

        const result = await response.json()

        if (result.success) {
          showNotification(result.message, 'success')

          // Сбрасываем форму
          Object.keys(form).forEach(key => {
            form[key] = ''
          })
        } else {
          showNotification(result.message, 'error')
        }

      } catch (error) {
        console.error('Ошибка отправки:', error)
        showNotification('Ошибка соединения с сервером. Пожалуйста, позвоните нам по телефону.', 'error')
      } finally {
        loading.value = false
      }
    }

    return {
      form,
      errors,
      loading,
      showMessage,
      messageText,
      messageType,
      submitForm
    }
  }
}
</script>

<style scoped>
/* Дополнительные стили для состояния загрузки */
.btn-form.loading {
  opacity: 0.7;
  cursor: not-allowed;
}

.btn-form:disabled {
  opacity: 0.7;
  cursor: not-allowed;
}

.fa-spinner {
  margin-right: 8px;
}

.form-message {
  padding: 12px 15px;
  margin: 15px 0;
  border-radius: 8px;
  text-align: center;
  font-weight: 500;
  font-size: 0.9rem;
}

.form-message.success {
  background: #d4edda;
  color: #155724;
  border: 1px solid #c3e6cb;
}

.form-message.error {
  background: #f8d7da;
  color: #721c24;
  border: 1px solid #f5c6cb;
}

/* Стили для контактной информации */
.contact-container {
  display: grid;
  grid-template-columns: 1fr;
  gap: 40px;
}

.contact-info {
  display: flex;
  flex-direction: column;
  gap: 20px;
}

.contact-card {
  background: var(--bg-light);
  padding: 25px;
  border-radius: 12px;
  border-left: 4px solid var(--primary);
}

.contact-card h3 {
  display: flex;
  align-items: center;
  gap: 8px;
  color: var(--text-dark);
  margin-bottom: 12px;
  font-size: 1.1rem;
}

.contact-card h3 i {
  color: var(--primary);
}

.contact-card p, .contact-card a {
  color: var(--text-light);
  line-height: 1.5;
  font-size: 0.9rem;
}

.contact-card a {
  text-decoration: none;
}

.contact-card a:hover {
  color: var(--primary);
}

.phones {
  display: flex;
  flex-direction: column;
  gap: 6px;
}

.contact-form-card {
  background: var(--bg-white);
  padding: 30px;
  border-radius: 15px;
  box-shadow: var(--shadow-lg);
}

.contact-form-card h3 {
  font-size: 1.3rem;
  margin-bottom: 8px;
}

.contact-form-card > p {
  color: var(--text-light);
  margin-bottom: 25px;
  font-size: 0.9rem;
}

/* Стили формы */
.form-group {
  position: relative;
  margin-bottom: 20px;
}

.form-group input,
.form-group select,
.form-group textarea {
  width: 100%;
  padding: 12px 15px;
  border: 2px solid var(--border);
  border-radius: 8px;
  font-size: 0.9rem;
  background: var(--bg-white);
  transition: all 0.3s ease;
  font-family: inherit;
  resize: vertical;
}

.form-group input:focus,
.form-group select:focus,
.form-group textarea:focus {
  border-color: var(--primary);
  outline: none;
}

.form-group label {
  position: absolute;
  top: 12px;
  left: 15px;
  background: var(--bg-white);
  padding: 0 5px;
  color: var(--text-light);
  transition: all 0.3s ease;
  pointer-events: none;
  font-size: 0.9rem;
}

.form-group input:focus + label,
.form-group select:focus + label,
.form-group textarea:focus + label,
.form-group input:not(:placeholder-shown) + label,
.form-group select:not(:placeholder-shown) + label,
.form-group textarea:not(:placeholder-shown) + label {
  top: -8px;
  font-size: 0.7rem;
  color: var(--primary);
}

.form-group select {
  appearance: none;
  background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
  background-repeat: no-repeat;
  background-position: right 12px center;
  background-size: 14px;
  padding-right: 35px;
}

.form-group textarea {
  min-height: 100px;
}

.error-message {
  color: var(--primary);
  font-size: 0.75rem;
  margin-top: 5px;
}

.btn-form {
  width: 100%;
  padding: 14px 25px;
  background: var(--gradient);
  color: white;
  border: none;
  border-radius: 8px;
  font-size: 1rem;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.3s ease;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
}

.btn-form:hover:not(:disabled) {
  transform: translateY(-2px);
  box-shadow: 0 5px 15px rgba(229, 57, 53, 0.4);
}

/* Адаптивность */
@media screen and (min-width: 768px) {
  .contact-container {
    grid-template-columns: 1fr 1fr;
    gap: 40px;
  }
}
</style>