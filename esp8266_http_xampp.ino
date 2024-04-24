#include <Arduino.h>
#include <ESP8266WiFi.h>
#include <ESP8266WiFiMulti.h>
#include <ESP8266HTTPClient.h>
#include <WiFiClient.h>
#include <Adafruit_Sensor.h>
#include <DHT.h>
#include <DHT_U.h>

#define DHTPIN D2     // Digital pin connected to the DHT sensor 
#define DHTTYPE DHT22     // DHT 22 (AM2302)

""" Setup wifi and server """
// String wifi name
const char* ssid     = "Bigboss_2.4G";
// String password name
const char* password = "0925655996";
// Set server
String api_server = "http://localhost:8080/iot_nutshell_php_code/add_data.php";

DHT_Unified dht(DHTPIN, DHTTYPE);
ESP8266WiFiMulti WiFiMulti;

void setup() 
{
  Serial.begin(115200);
  // Serial.setDebugOutput(true);
  dht.begin();
  Serial.println();
  Serial.println();
  Serial.println();

  for (uint8_t t = 4; t > 0; t--) 
  {
    Serial.printf("[SETUP] WAIT %d...\n", t);
    Serial.flush();
    delay(1000);
  }

  WiFi.mode(WIFI_STA);
  WiFiMulti.addAP("EPS-TOT", "");
}


void loop() 
{
  String sensor_name = "node1";
  sensors_event_t event;
  dht.temperature().getEvent(&event);
  float temperature;
  float humidity;

  if (isnan(event.temperature)) 
  {

    Serial.println(F("Error reading temperature!"));
  }
  else 
  {
    temperature = event.temperature;
    Serial.print(F("Temperature: "));
    Serial.print(event.temperature);
    Serial.println(F("°C"));
  }

  // Get humidity event and print its value.
  dht.humidity().getEvent(&event);
  if (isnan(event.relative_humidity)) 
  {
    Serial.println(F("Error reading humidity!"));
  }
  else 
  {
    Serial.print(F("Humidity: "));
    Serial.print(event.relative_humidity);
    Serial.println(F("%"));
  }
  
  // wait for WiFi connection
  if ((WiFiMulti.run() == WL_CONNECTED)) 
  {
    WiFiClient client;

    HTTPClient http;
    String urlString =  "http://10.10.9.69/temperature_app/add_data.php";
    urlString += "?temp=";
    urlString += String(temperature);
    urlString += "&humid=";
    urlString += String(event.relative_humidity);
    urlString += "&name='";
    urlString += sensor_name;
    urlString += "'";
    Serial.print(urlString);
    Serial.print("[HTTP] begin...\n");

    if (http.begin(client, urlString)) 
    { // HTTP
      Serial.print("[HTTP] GET...\n");
      // start connection and send HTTP header
      int httpCode = http.GET();

      // httpCode will be negative on error
      if (httpCode > 0) {
        // HTTP header has been send and Server response header has been handled
        Serial.printf("[HTTP] GET... code: %d\n", httpCode);

        // file found at server
        if (httpCode == HTTP_CODE_OK || httpCode == HTTP_CODE_MOVED_PERMANENTLY) {
          String payload = http.getString();
          Serial.println(payload);
        }
      } 
      else 
      {
        Serial.printf("[HTTP] GET... failed, error: %s\n", http.errorToString(httpCode).c_str());
      }

      http.end();
    } 
    else 
    {
      Serial.printf("[HTTP} Unable to connect\n");
    }
    
  }

  delay(10000);
}
