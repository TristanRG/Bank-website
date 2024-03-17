import axios from "axios";

const nume = ref("");
const prenume = ref("");
const parola = ref("");
const cnp = ref("");
const adresa = ref("");
const numar_telefon = ref("");
const email = ref("");


  try {
    await axios.post("http://localhost/test.php", {
      Nume: nume.value,
      Prenume: prenume.value,
      Parola: parola.value,
      CNP: cnp.value,
      Adresa: adresa.value,
      Numar_Telefon: numar_telefon.value,
      Email: email.value,
    });
  }
  catch (error) {
    console.error(error);
  }


