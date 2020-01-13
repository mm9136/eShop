package com.example.eshop;

import androidx.appcompat.app.AppCompatActivity;

import android.app.ProgressDialog;
import android.content.Intent;
import android.os.Bundle;
import android.text.TextUtils;
import android.view.View;
import android.widget.EditText;
import android.widget.TextView;
import android.widget.Toast;
import com.google.android.gms.tasks.Continuation;
import com.google.android.gms.tasks.OnCompleteListener;
import com.google.android.gms.tasks.Task;
import com.example.eshop.Prevalent.Prevalent;
import java.util.HashMap;

import de.hdodenhof.circleimageview.CircleImageView;

public class SettingsActivity extends AppCompatActivity {

    //private CircleImageView profileImageView;
    //private  TextView profileChangeTextBtn;
    private EditText firstNameEditText,lastNameEditText,addressEditText,phoneNumberEditText,passwordEditText;
    private TextView closeTextBtn,saveTextBtn;

    
    private String checker = "";
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_settings);

        firstNameEditText= (EditText)findViewById(R.id.settings_firstname);
        lastNameEditText=(EditText)findViewById(R.id.settings_lastname);
        addressEditText=(EditText)findViewById(R.id.settings_adress);
        phoneNumberEditText=(EditText)findViewById(R.id.settings_phone_number);
        passwordEditText=(EditText)findViewById(R.id.settings_password);
        closeTextBtn=(TextView)findViewById(R.id.close_settings_btn);
        saveTextBtn=(TextView)findViewById(R.id.update_settings_btn);

        //userInfoDisplay(firstNameEditText,lastNameEditText,addressEditText,phoneNumberEditText,passwordEditText);

        closeTextBtn.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                finish();
            }
        });
        saveTextBtn.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                updateOnlyUserInfo();

            }
        });
    }

    private void updateOnlyUserInfo() {
        if(TextUtils.isEmpty(firstNameEditText.getText().toString())){
            Toast.makeText(this, "First Name is mandatory", Toast.LENGTH_SHORT).show();
        }
        else if(TextUtils.isEmpty(lastNameEditText.getText().toString())){
            Toast.makeText(this, "Last Name is mandatory", Toast.LENGTH_SHORT).show();
        }
        else if(TextUtils.isEmpty(addressEditText.getText().toString())){
            Toast.makeText(this, "Address is mandatory", Toast.LENGTH_SHORT).show();
        }
        else if(TextUtils.isEmpty(phoneNumberEditText.getText().toString())){
            Toast.makeText(this, "Phone Number is mandatory", Toast.LENGTH_SHORT).show();
        }
        else if(TextUtils.isEmpty(passwordEditText.getText().toString())){
            Toast.makeText(this, "Password is mandatory", Toast.LENGTH_SHORT).show();
        }
        else{
            uploadInfo();
        }


    }
    private void uploadInfo(){
            final ProgressDialog progressDialog = new ProgressDialog(this);
            progressDialog.setTitle("Update Profile");
            progressDialog.setMessage("Wait while we are updating your profile");
            progressDialog.setCanceledOnTouchOutside(false);
            progressDialog.show();

                HashMap<String,Object> userMap = new HashMap<>();

                userMap.put("firstName",firstNameEditText.getText().toString());
                userMap.put("lastName",lastNameEditText.getText().toString());
                userMap.put("address",addressEditText.getText().toString());
                userMap.put("phoneNumber",phoneNumberEditText.getText().toString());
                userMap.put("password",passwordEditText.getText().toString());

                //ref.child(Prevalent.currentOnlineUser.getPhone()).updateChildren(userMap);
                startActivity(new Intent(SettingsActivity.this, MainActivity.class));
                Toast.makeText(SettingsActivity.this, "Profile info update successfully", Toast.LENGTH_SHORT).show();
                finish();




    }


/*
    private void userInfoDisplay(final EditText firstNameEditText, EditText lastNameEditText, EditText addressEditText, EditText phoneNumberEditText, EditText passwordEditText) {
        DatabaseReference UserRef= FirebaseDatabase.getInstance().getReference().child("Users").child(Prevalent.currentOnlineUser.getFirstName());
        UserRef.addValueEventListener(new ValueEventListener() {
            @Override
            public void onDataChange(DataSnapshot dataSnapshot){
                if (dataSnapshot.exists())
                    if(dataSnapshot.child("firstName").exists()){
                        String firstName = dataSnapshot.child("firstName").getValue().toString();
                        String lastName = dataSnapshot.child("lastName").getValue().toString();
                        String address = dataSnapshot.child("address").getValue().toString();
                        String phoneNumber = dataSnapshot.child("phoneNumber").getValue().toString();
                        String password = dataSnapshot.child("password").getValue().toString();



                        firstNameEditText.setText(firstName);
                        lastNameEditText.setText(lastName);
                        addressEditText.setText(address);
                        phoneNumberEditText.setText(phoneNumber);
                        passwordEditText.setText(password);

                    }
            }
            @Override
            public void onCancelled(DataSnapshot dataSnapshot){

             }
       });
        DatabaseReference UserRef= FirebaseDatabase.getInstance().getReference().child("Users").child(Prevalent.currentOnlineUser.getLastName());
        DatabaseReference UserRef= FirebaseDatabase.getInstance().getReference().child("Users").child(Prevalent.currentOnlineUser.getAddress());
        DatabaseReference UserRef= FirebaseDatabase.getInstance().getReference().child("Users").child(Prevalent.currentOnlineUser.getPhoneNumber());
        DatabaseReference UserRef= FirebaseDatabase.getInstance().getReference().child("Users").child(Prevalent.currentOnlineUser.getPassword());

    }*/
}
