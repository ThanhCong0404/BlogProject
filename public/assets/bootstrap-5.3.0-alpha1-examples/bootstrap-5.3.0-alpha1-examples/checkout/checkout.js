// Utility function to add event listener to all elements matching a selector
const addEventListenerToAll = (selector, eventName, callback) => {
  Array.from(document.querySelectorAll(selector)).forEach(element => {
    element.addEventListener(eventName, callback, false)
  })
}

// Function to handle form submission and validation
const handleFormSubmission = (form) => {
  if (!form.checkValidity()) {
    event.preventDefault()
    event.stopPropagation()
  }

  form.classList.add('was-validated')
}

// Apply the validation behavior to all forms with the "needs-validation" class
addEventListenerToAll('.needs-validation', 'submit', (event) => {
  handleFormSubmission(event.target)
})
