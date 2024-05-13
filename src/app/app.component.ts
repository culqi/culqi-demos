import { Component } from '@angular/core';
import { RouterOutlet } from '@angular/router';
import { ButtonComponent } from './shared/component/button/button.component';
import { SidebarComponent } from './shared/component/sidebar/sidebar.component';

@Component({
  selector: 'app-root',
  standalone: true,
  templateUrl: './app.component.html',
  styleUrl: './app.component.css',
  imports: [RouterOutlet, SidebarComponent, ButtonComponent],
})
export class AppComponent {
  title = 'culqi-demos';

  reset(): void {
    console.log('reset');
    window.location.reload();
  }
}
