package com.example.eshop;

import android.app.ProgressDialog;
import android.content.Intent;
import android.os.Bundle;
import android.text.TextUtils;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Toast;

import androidx.appcompat.app.AppCompatActivity;

public class loginActivity extends AppCompatActivity {
    private EditText InputEmail,InputPassword;
    private Button LoginButton;
    private ProgressDialog loadingBar;

    private String parentDbName= "Users";
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_login);

        LoginButton= (Button) findViewById(R.id.login_btn);
        InputPassword=(EditText) findViewById(R.id.login_password_input);
        InputEmail=(EditText)findViewById(R.id.login_email_input);
        //loadingBar= new ProgressDialog(this);

        LoginButton.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                LoginUser();
            }
        });
    }

    private void LoginUser(){
        String email= InputEmail.getText().toString();
        String password= InputPassword.getText().toString();

        if(TextUtils.isEmpty(email)){
            Toast.makeText(this, "Please insert your email adress", Toast.LENGTH_SHORT).show();
        }
        else if(TextUtils.isEmpty(password)){
            Toast.makeText(this, "please insert your password", Toast.LENGTH_SHORT).show();
        }
        else{
            backgroung bg =new backgroung(this);
            bg.execute(email,password);
            //Intent intent = new Intent(loginActivity.this, HomeActivity.class);
            Intent intent = new Intent(loginActivity.this, ListProductActivity.class);
            startActivity(intent);
        }

    }

}
