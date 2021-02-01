import { HttpClient } from "@angular/common/http";
import { Injectable } from "@angular/core";
import { Patient } from "../models/patient.model";

@Injectable({providedIn: 'root'})
export class PatientService {
  listePatients: Patient[];
  constructor (private http: HttpClient){

  }

  searchAllPatients(){
    return this.http.get<Patient[]>("http://localhost:8000/patients", {observe: 'response'});
  }

  searchPatientById(){
    return this.http.get<Patient[]>("http://localhost:8000/patient/{id}", {observe: 'response'});
  }

  addPatient(){
    return this.http.post<Patient[]>("http://localhost:8000/patients", {observe: 'response'});
  }

}
