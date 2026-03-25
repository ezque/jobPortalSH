<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'

const form = ref({
  fullName: '',
  birthDate: '',
  gender: '',
  email: '',
  phone: '',
  address: '',
  ethnicity: '',
  nationality: '',
  pronouns: '',
  program: '',
  languages: '',
  file: null,
})

const alreadyApplied = ref(false)
const jobId = 7 // 🔥 change this dynamically later

const handleFile = (e) => {
  form.value.file = e.target.files[0]
}

const checkIfApplied = async () => {
  try {
    const res = await axios.get(`/check-application/${jobId}`)
    alreadyApplied.value = res.data.applied
  } catch (e) {
    console.log(e)
  }
}

const submitForm = async () => {
  if (alreadyApplied.value) {
    alert('You already applied!')
    return
  }

  const formData = new FormData()
  Object.keys(form.value).forEach(key => {
    formData.append(key, form.value[key])
  })

  try {
    await axios.post(`/submit/application-form/${jobId}`, formData)
    alert('Application Submitted!')
    alreadyApplied.value = true
  } catch (e) {
    alert('Error submitting form')
  }
}

onMounted(() => {
  checkIfApplied()
})
</script>

<template>
  <div class="wrapper">
    <div class="form-container">
      
      <!-- Header -->
      <div class="header">
        <img src="/logo.png" class="logo" />
        <h2>Application Form for Contruction Worker</h2>
      </div>

      <!-- Form -->
      <div class="form-box">

        <!-- Row 1 -->
        <div class="grid-2">
          <input v-model="form.fullName" placeholder="Full Name" />
          <input type="date" v-model="form.birthDate" />
        </div>

        <!-- Row 2 -->
        <div class="grid-3">
          <select v-model="form.gender">
            <option disabled value="">Gender</option>
            <option>Male</option>
            <option>Female</option>
          </select>
          <input v-model="form.email" placeholder="Email Address" />
          <input v-model="form.phone" placeholder="Phone Number" />
        </div>

        <!-- Address -->
        <textarea v-model="form.address" placeholder="Home Address"></textarea>

        <!-- Row 3 -->
        <div class="grid-3">
          <input v-model="form.ethnicity" placeholder="Ethnicity" />
          <input v-model="form.nationality" placeholder="Nationality" />
          <input v-model="form.pronouns" placeholder="Preferred Pronouns" />
        </div>

        <!-- Row 4 -->
        <div class="grid-3">
          <input value="Construction Worker" disabled />
          <input v-model="form.program" placeholder="Program Name" />
          <input v-model="form.languages" placeholder="Languages Spoken" />
        </div>

        <!-- File -->
        <input type="file" @change="handleFile" />

        <!-- Buttons -->
        <div class="buttons">
          <button class="cancel">Cancel</button>
          <button 
            class="apply" 
            @click="submitForm"
            :disabled="alreadyApplied"
          >
            {{ alreadyApplied ? 'Already Applied' : 'Apply Job' }}
          </button>
        </div>

      </div>
    </div>
  </div>
</template>

<style scoped>
.wrapper {
  background: #f5f5f5;
  min-height: 100vh;
  padding: 30px;
}

.form-container {
  max-width: 900px;
  margin: auto;
  background: #fff;
  padding: 20px;
  border-radius: 10px;
}

.header {
  display: flex;
  align-items: center;
  gap: 10px;
  margin-bottom: 20px;
}

.logo {
  width: 40px;
}

.form-box {
  border: 2px solid #3b82f6;
  padding: 20px;
  border-radius: 10px;
}

.grid-2 {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 10px;
  margin-bottom: 10px;
}

.grid-3 {
  display: grid;
  grid-template-columns: 1fr 2fr 2fr;
  gap: 10px;
  margin-bottom: 10px;
}

input, select, textarea {
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 5px;
}

textarea {
  width: 100%;
  margin-bottom: 10px;
}

.buttons {
  display: flex;
  justify-content: flex-end;
  gap: 10px;
  margin-top: 15px;
}

.cancel {
  padding: 10px 20px;
}

.apply {
  background: #16a34a;
  color: white;
  padding: 10px 20px;
  border: none;
}

.apply:disabled {
  background: gray;
}
</style>