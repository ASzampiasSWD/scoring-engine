# Author: Amanda Szampias
# Date: September 13, 2019
# Description: Basic Service Engine

import requests
import mysql.connector

mydb = mysql.connector.connect(
  host="localhost",
  user="amanda",
  passwd="amandaPanda",
  database="ccdc_ise"
)

mycursor = mydb.cursor()



def checkHTTP(strProtocol):
  with open ("websites.txt") as file:
    ips = file.readlines()
    ips = [x.strip() for x in ips] 
    for ip in ips:
      strPort = 80
      if (strProtocol == 'https://'):
        strPort = 443
      try:
        strIP = ip
        print(strIP)
        website = strProtocol + ip;
        response = requests.get(website,verify=False, timeout=1)
        #print(response.status_code)
        sql = ("UPDATE ScoredService SET is_active = 0 WHERE team_id = (SELECT team_id FROM Team WHERE ip = %s) AND service_id = (SELECT service_id FROM Service WHERE port = %s)")
        if response.status_code == '200':
          sql = ("UPDATE ScoredService SET is_active = 1 WHERE team_id = (SELECT team_id FROM Team WHERE ip = %s) AND service_id = (SELECT service_id FROM Service WHERE port = %s)")
        mycursor.execute(sql, (strIP,strPort,))
        mydb.commit()
        print(mycursor.rowcount, "record(s) affected")
      except requests.exceptions.ConnectionError as t:
        #sql = ("UPDATE Service SET is_active = 0 WHERE ip = %s AND port = %")
	sql = ("UPDATE ScoredService SET is_active = 0 WHERE team_id = (SELECT team_id FROM Team WHERE ip = %s) AND service_id 	= (SELECT service_id FROM Service WHERE port = %s)")
        mycursor.execute(sql, (strIP, strPort,))
        mydb.commit()
        print(mycursor.rowcount, "record(s) affected")
        print('The connection timed out: ' + website)
      except Exception as e:
        print('An error has occured: ' + str(e))
        
    
    
def main():
  while True:
    checkHTTP('http://')
    checkHTTP('https://')

    
if __name__ == "__main__":
  main()
