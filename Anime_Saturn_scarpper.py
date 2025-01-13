from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.firefox.service import Service
from selenium.webdriver.firefox.options import Options
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from selenium.common.exceptions import NoSuchElementException, TimeoutException
import mysql.connector

def trova_pulsante_successivo(driver):
    try:
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
        titolo_elemento = WebDriverWait(driver, 10).until(
            EC.presence_of_element_located((By.CSS_SELECTOR, 'h4.text-white.mb-3'))
        )
        return titolo_elemento.text.strip()
    except TimeoutException:
        return "Titolo non trovato"

def url_esistente(cursor, url, titolo):
    cursor.execute("SELECT 1 FROM estrapolazioni WHERE Url = %s AND titolo = %s", (url, titolo))
    return cursor.fetchone() is not None

def preleva_url_iniziali(cursor):
    cursor.execute("SELECT id, url FROM Url_iniziali")
    return cursor.fetchall()

def elimina_url_iniziale(cursor, conn, url_id):
    cursor.execute("DELETE FROM Url_iniziali WHERE id = %s", (url_id,))
    conn.commit()

# Connetti al database
conn = mysql.connector.connect(
    host="localhost",
    user="estrapolatore",
    password="password",  # Sostituisci con la password corretta
    database="anime"
)
cursor = conn.cursor()

# Opzioni per il browser
firefox_options = Options()
firefox_options.add_argument("--headless")
firefox_options.accept_insecure_certs = True

# Imposta il percorso del driver di Firefox
selenium_service = Service('/usr/local/bin/geckodriver')

# Inizializza il driver di Selenium con Firefox
driver = webdriver.Firefox(service=selenium_service, options=firefox_options)

# Preleva tutti gli URL iniziali dalla tabella
url_iniziali = preleva_url_iniziali(cursor)

for url_id, url in url_iniziali:
    while url:
        print("URL corrente:", url)
        driver.get(url)
        
        try:
            # Attendi che la pagina si carichi completamente
            WebDriverWait(driver, 10).until(EC.presence_of_element_located((By.TAG_NAME, "body")))

            # Estrai il titolo
            titolo = trova_titolo(driver)
            print("Titolo estratto:", titolo)

            # Controlla se l'URL e il titolo sono già nel database
            if url_esistente(cursor, url, titolo):
                print("URL e titolo già presenti nel database. Salto...")
            else:
                # Inserisci l'URL e il titolo nel database
                cursor.execute("INSERT INTO estrapolazioni (Url, titolo) VALUES (%s, %s)", (url, titolo))
                conn.commit()
                print("URL e titolo salvati nel database.")

            # Trova il prossimo URL
            url_successivo = trova_pulsante_successivo(driver)
            if url_successivo:
                if not url_successivo.startswith("https://www.animesaturn.cx"):
                    url_successivo = "https://www.animesaturn.cx" + url_successivo
                url = url_successivo
            else:
                print("Nessun pulsante 'Episodio Successivo' trovato.")
                break
        except TimeoutException:
            print("La pagina non si è caricata in tempo.")
            break

    # Elimina l'URL dalla tabella Url_iniziali una volta completato
    elimina_url_iniziale(cursor, conn, url_id)
    print(f"URL con ID {url_id} rimosso dalla tabella Url_iniziali.")

print("Tutti gli URL iniziali sono stati elaborati.")

# Chiudi il database e il driver
cursor.close()
conn.close()
driver.quit()