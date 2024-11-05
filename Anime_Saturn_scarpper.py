from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.firefox.service import Service
from selenium.webdriver.firefox.options import Options
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from selenium.common.exceptions import NoSuchElementException, TimeoutException
import os
import time

def trova_pulsante_successivo(driver):
    try:
        # Attendi che l'icona del pulsante successivo sia visibile
        pulsante_successivo = WebDriverWait(driver, 10).until(
            EC.presence_of_element_located((By.CSS_SELECTOR, 'i.bi.bi-arrow-right'))
        )
        if pulsante_successivo:
            onclick_attr = pulsante_successivo.find_element(By.XPATH, "..").get_attribute("onclick")
            url_successivo = onclick_attr.split("'")[1]
            return url_successivo
    except (TimeoutException, NoSuchElementException, KeyError):
        return None

def trova_titolo(driver):
    try:
        # Attendi che il titolo <h4> sia visibile e ottieni il testo
        titolo_elemento = WebDriverWait(driver, 10).until(
            EC.presence_of_element_located((By.CSS_SELECTOR, 'h4.text-white.mb-3'))
        )
        return titolo_elemento.text.strip()
    except TimeoutException:
        return "Titolo non trovato"

# URL iniziale
url = 'https://www.animesaturn.tv/watch?file=LmpYn3eOXjazj&server=0'

# Percorso del file di output
percorso_file = os.path.expandvars(r'C:\Users\%username%\Desktop\estrazionediprova.txt')

# Opzioni per il browser
firefox_options = Options()
firefox_options.add_argument("--headless")
firefox_options.accept_insecure_certs = True

# Imposta il percorso del driver di Firefox
selenium_service = Service(r'path\to\geckodriver')

# Inizializza il driver di Selenium con Firefox
driver = webdriver.Firefox(service=selenium_service, options=firefox_options)

url_list = []

with open(percorso_file, 'w') as file:
    while True:
        print("URL corrente:", url)
        driver.get(url)
        
        try:
            # Attendi che la pagina si carichi completamente
            WebDriverWait(driver, 10).until(EC.presence_of_element_located((By.TAG_NAME, "body")))
            
            # Estrai il titolo
            titolo = trova_titolo(driver)
            print("Titolo estratto:", titolo)

            # Salva l'URL e il titolo nel file
            file.write(f"{url} - {titolo}\n")
            url_list.append((url, titolo))

            # Trova il prossimo URL
            url_successivo = trova_pulsante_successivo(driver)

            if url_successivo:
                if not url_successivo.startswith("https://www.animesaturn.tv"):
                    url_successivo = "https://www.animesaturn.tv" + url_successivo
                url = url_successivo
            else:
                print("Nessun pulsante 'Episodio Successivo' trovato.")
                break
        except TimeoutException:
            print("La pagina non si è caricata in tempo.")
            break

print("URL e titoli estratti salvati correttamente nel file:", percorso_file)

driver.quit()
