package com.example.eshop;

import android.app.AlertDialog;
import android.content.Context;
import android.os.AsyncTask;

import java.io.BufferedReader;
import java.io.BufferedWriter;
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.io.OutputStream;
import java.io.OutputStreamWriter;
import java.net.HttpURLConnection;
import java.net.MalformedURLException;
import java.net.URL;
import java.net.URLEncoder;
public class backgroung extends AsyncTask <String,Void,String> {
    AlertDialog dialog;
    Context context ;
    public backgroung (Context context){
        this.context=context;
    }
    @Override
    protected void onPreExecute() {
        dialog = new AlertDialog.Builder(context).create();
        dialog.setTitle("Login status");
    }

    @Override
    protected void onPostExecute(String s) {
        dialog.setMessage(s);
        dialog.show();
    }

    @Override
    protected String doInBackground(String... voids) {
        String result ="";
        String email = voids[0];
        String password = voids[1];

        //String connstr = "http://127.0.0.1:3306/eShop/login.php";
        //String connstr = "http://10.0.3.2:8080/eShop/login.php";
        //String connstr = "http://192.168.1.8/eShop/";//

/*
        If both your desktop and phone are connected to the same WiFi (or any other local network),
        then use your desktop IP address assigned by the router (not localhost and not 127.0.0.1).
*/
        String connstr = "http://10.0.2.2:63342/eShop/login.php";
        //@GET("login.php");
        try{

            URL url = new URL(connstr);
            HttpURLConnection http = (HttpURLConnection) url.openConnection();
            http.setRequestMethod("POST");
            http.setDoInput(true);
            http.setDoOutput(true);

            OutputStream ops = http.getOutputStream();
            BufferedWriter writer= new BufferedWriter(new OutputStreamWriter(ops,"UTF-8"));
            String data= URLEncoder.encode("email","UTF-8") + "=" + URLEncoder.encode(email,"UTF-8") +"&&" +
                    URLEncoder.encode("password","UTF-8") + "=" + URLEncoder.encode(password,"UTF-8");

            writer.write(data);
            writer.flush();
            writer.close();
            ops.close();

            InputStream ips= http.getInputStream();
            BufferedReader reader = new BufferedReader( new InputStreamReader(ips,"ISO-8859-1"));
            String line ="";
            while((line=reader.readLine())!= null){
                result += line;
            }
            reader.close();
            ips.close();
            http.disconnect();
            return result;

        }catch(MalformedURLException e){
            result= e.getMessage();

        }catch (IOException e){
            result=e.getMessage();
        }


        return result;
    }
}
