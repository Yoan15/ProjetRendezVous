import { HttpClient } from "@angular/common/http";
import { Injectable } from "@angular/core";
import { Specialite } from "../models/specialite.model";

@Injectable({providedIn: 'root'})
export class SpecialiteService {
  listeSpecialites: Specialite[];
  constructor (private http: HttpClient){

  }

  searchAllSpecialites(){
    return this.http.get<Specialite[]>("http://localhost:8000/specialites", {observe: 'response'});
  }

}
